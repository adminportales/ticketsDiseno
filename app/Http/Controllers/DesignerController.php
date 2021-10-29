<?php

namespace App\Http\Controllers;

use App\Message;
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
        $tickets = auth()->user()->assignedTickets()->orderByDesc('created_at')->get();;

        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;

        foreach ($tickets as $ticket) {
            $statusTicket = $ticket->latestStatusChangeTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }
        // MOstramos la vista
        return view('designer.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }

    // Muestra todos los tickets asignanos a ese diseñador
    public function index()
    {
        //Traer los tickets asignados
        $tickets = auth()->user()->assignedTickets()->orderByDesc('created_at')->get();;
        //Mostrar la vista
        return view('designer.index', compact('tickets'));
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

        return view(
            'designer.showTicket',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories', 'ticketDeliveries')
        );
    }
}
