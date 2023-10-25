<?php

namespace App\Http\Controllers;

use App\Message;
use App\Status;
use App\Ticket;
use App\TicketAssignProcess;
use App\TicketDelivery;
use App\TicketHistory;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
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
        return view('designer.listWait');
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
}
