<?php

namespace App\Http\Controllers;

use App\Message;
use App\ReassignmentTicket;
use App\Status;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Illuminate\Http\Request;

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
        // MOstramos la vista
        return view('designer.dashboard', compact('tickets'));
    }

    // Muestra todos los tickets asignanos a ese diseñador
    public function index()
    {
        //Mostrar la vista
        return view('designer.index');
    }

    public function list()
    {
        // Buscar tickets que no tengan diseñador
        $tickets = Ticket::where('designer_id', null)->paginate(5);
        return view('designer.waitinglist',  compact('tickets'));
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
        $ticketDeliveries = $ticket->deliveryTicket;
        $userall = User::join('role_user', 'users.id', 'role_user.user_id')
        ->whereIn('role_user.role_id', [3, 5])
        ->where('users.id', '!=', auth()->user()->id)
        ->where('users.status', 1)
        ->get();

        return view(
            'designer.showTicket',
            compact('userall', 'messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories', 'ticketDeliveries')
        );
    }

    public function reasignTicket(Request $request)
    {

        // Validar datos si es necesario
        $ticketId = $request->input('ticket_id');
        $designerId = $request->input('designer_id');
        $designerName = $request->input('designer_name');
        $selectedDesignerId = $request->input('designer_receives_id');
        $selectedDesignerName = $request->input('designer_receives');

        // Guardar en la base de datos
        $reassignment = new ReassignmentTicket();
        $reassignment->ticket_id = $ticketId;
        $reassignment->designer_id = $designerId;
        $reassignment->designer_name = $designerName;
        $reassignment->designer_receives_id = $selectedDesignerId;
        $reassignment->designer_receives = $selectedDesignerName;
        $reassignment->save();

        return response()->json(['success' => true]);
    }
}
