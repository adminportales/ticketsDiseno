<?php

namespace App\Http\Controllers;

use App\Message;
use App\Notifications\MessageNotification;
use App\Notifications\MissingInformation;
use App\Notifications\StatusTicket;
use App\Role;
use App\SatisfactionModel;
use App\Status;
use App\Ticket;
use App\TicketAssigment;
use App\TicketAssignProcess;
use App\TicketDelivery;
use App\TicketHistory;
use App\TicketInformation;
use App\TicketStatusChange;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class DesignerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Resumen generarl del diseñador
    static function dashboard()
    {
        // Leemos los tickets que se asignaron al ususrio y obtenemos su estado
        $tickets = auth()->user()->assignedTickets()->where('status_id', '!=', 6)->where('status_id', '!=', 3)->orderByDesc('created_at')->paginate(5);
        $ticketsToTransferMe = auth()->user()->latestTicketsToTransferMe()->where('status', 'En proceso de traspaso')->select("ticket_id")->get();
        $ticketsToTransfer = Ticket::whereIn('id', $ticketsToTransferMe)->orderByDesc('created_at')->get();
        // MOstramos la vista
        return view('designer.dashboard', compact('tickets', 'ticketsToTransfer'));
    }

    // Muestra todos los tickets asignanos a ese diseñador
    public function index()
    {
        //Mostrar la vista
        return view('designer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        // Obtener la informaciocion de el ticket y su historial
        $ticketInformation = $ticket->ticketInformation()->orderByDesc('created_at')->get();
        $messages = $ticket->messagesTicket()->orderByDesc('created_at')->get();
        $statuses = Status::all();
        $statusTicket = $ticket->latestStatusChangeTicket->status;

        $ticketHistories = $ticket->historyTicket;
        //dd($ticketHistories);
        $ticketDeliveries = $ticket->deliveryTicket;
        // dd($ticketDeliveries);
        $delivery = TicketDelivery::where('ticket_id', $ticket->id)
            ->select('files')->get();
        return view(
            'designer.showTicket',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories', 'ticketDeliveries', 'delivery')
        );
    }

    // Muestra la lista de tickets en espera
    public function listWait()
    {
        // Mostramos la vista
        ///////////AQUÍ//////////
        return view('designer.listWait');
    }
    public function listEncuesta($designer)
    {
        $user_designers = Role::find(3)->whatUsers->where('status', 1);

        $info = [];

        /*    foreach ($user_designers as $designer) {
            $designerName = $designer->name . ' ' . $designer->lastname; */

        $satisfactions = SatisfactionModel::where('designer', $designer)->get();
        if ($satisfactions->isNotEmpty()) {
            foreach ($satisfactions as $satisfaction) {
                $ticket_name = TicketInformation::where('ticket_id', $satisfaction->ticket_id)->select('description')->first();
                $description_text = strip_tags($ticket_name['description']);
                $description_text = html_entity_decode($description_text);

                $dataSatisfaction = [
                    'diseñador' => $designer,
                    'ticket_id' => $description_text,
                    'pregunta' => $satisfaction->question,
                    'respuesta' => $satisfaction->answer,
                    'comentario' => $satisfaction->comment,
                ];
                $info[] = $dataSatisfaction;
            }
        }

        return view('designer.listEncuesta', compact('info'));
    }
    public function deleteFile($delivery_id)
    {


        $delivery = TicketDelivery::find($delivery_id);

        $delete = $delivery->active;
        if ($delete == 1) {
            $delivery->update(['active' => false]);
        }
        $delivery = TicketDelivery::find($delivery_id);
        return redirect()->back();
    }

    public function returnticket(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'ticketid' => 'required',
            'message' => 'required'
        ]);

        //Obtenemos el título del ticket///
        $Ticket = DB::table('ticket_informations')->where('ticket_id', $request->ticketid)->first();
        $title = $Ticket->title;

        //OBTENEMOS EL NAME DEL USUARIO LOGEADO (ENVIARA EL CORREO)
        $send = $user->name;

        ///OBTENEMOS EL ID DEL CREADOR DEL TICKET///
        $ticket = DB::table('tickets')->where('id', $request->ticketid)->first();
        $creatorId = $ticket->creator_id;

        //OBTENEMOS EL NAME DEL CREADOR DEL TICKET///
        $username = DB::table('users')->where('id', $creatorId)->first();
        $name = $username->name;

        ///////Obtenemos el nombre del rol
        $rol = DB::table('role_user')->where('user_id', $user->id)->first();
        $id_rol = $rol->role_id;
        $name_rol = DB::table('roles')->where('id', $id_rol)->first();
        ////////////////////////////////////
        ////Creamos el registro de que se regreso el ticket/////
        $return_ticket = TicketStatusChange::create([
            'ticket_id' => $request->ticketid,
            'status_id' => 7,
            'status' => 'Falta de información',

        ]);

        $status = $return_ticket->status;
        //dd($status);

        TicketHistory::create([
            'ticket_id' => $request->ticketid,
            'reference_id' => $return_ticket->id,
            'type' => 'status',
        ]);

        ///////CREAMOS UN MENSAJE//////////////////////////////
        $Message = Message::create([
            'transmitter_id' => $user->id,
            'transmitter_name' => $user->name,
            'transmitter_role' => $name_rol->name,
            'receiver_id' =>  $creatorId,
            'receiver_name' => $name,
            'message' => $request->message,
            'ticket_id' => $request->ticketid
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'reference_id' => $Message->id,
            'type' => 'message'
        ]);
        $desginer_id = auth()->user()->id;

        ///////////////////////////////////////////////////////
        TicketAssignProcess::create([
            'ticket_id' => $ticket->id,
            'designer_id' => $desginer_id,
            'designer_name' => $user->name,
            'designer_received_id' => null,
            'designer_received_name' => null,
            'date_response' => now(),
            'status' => 'Seleccionado',
        ]);
        $ticket = Ticket::where('id', $ticket->id)->first();
        DB::table('tickets')->where('id', $ticket->id)->update([
            'seller_id' => $ticket->seller_id,
            'creator_name' => $ticket->creator_name,
            'creator_id' => $ticket->creator_id,
            'seller_name' => $ticket->seller_name,
            'designer_id' => $desginer_id,
            'designer_name' => $user->name,
            'priority_id' => $ticket->priority_id,
            'type_id' => $ticket->type_id,
            'subtype_id' => $ticket->subtype_id,
            'status_id' => $ticket->status_id,
        ]);
        $ticket = Ticket::where('id', $ticket->id)->first();
        ///CON AYUDA DEL ID DEL CREADOR SE LE ENVIARA EL CORREO///
        $user = User::find($creatorId);
        try {
            $user->notify(new MissingInformation($title, $send, $name, $request->ticketid, $request->message));
            $user->notify(new StatusTicket($title, $status, $send, $ticket->id));
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo enviar las notificaciones']);
        }

        return redirect()->back();
    }
}
