<?php

namespace App\Http\Controllers;

use App\Message;
use App\Status;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function index()
    {

        $tickets = auth()->user()->assignedTickets;

        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;

        foreach ($tickets as $ticket) {
            $statusTicket = $ticket->latestTicketInformation->statusTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }

        //Mostrar la vista
        return view('designer.index', compact('totalTickets', 'tickets', 'openTickets', 'closedTickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * Registrar el mensaje
     */
    public function store(Request $request)
    {
        // Obtener los datos del formulario de mensajes
        request()->validate([
            'message' => ['required', 'string'],
            'ticket_id' => ['required']
        ]);


        // Obtener el id del ticket, hay traerlo del formulario
        $ticket = Ticket::find($request->ticket_id);

        // Obtener el id y nombre del vendedor y diseñador asignados al ticket
        $transmitter_id = auth()->user()->id;
        $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        $userReceiver = User::find($ticket->seller_id);
        $receiver_id = $userReceiver->id;
        $receiver_name = $userReceiver->name . ' ' . $userReceiver->lastname;
        // Guardar el mensaje con los sigioetes datos

        $message = Message::create([
            "transmitter_id" => $transmitter_id,
            "transmitter_name" => $transmitter_name,
            'transmitter_role' =>auth()->user()->whatRoles[0]->name,
            "receiver_id" => $receiver_id,
            "receiver_name" => $receiver_name,
            "message" => $request->message,
            "ticket_id" => $ticket->id
        ]);

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'reference_id' => $message->id,
            'type' => 'message'
        ]);



        // Regresar a la misma vista AtenderTicket (ticket.show)
        return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
    }
    //

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticketInformation = $ticket->ticketInformation()->orderByDesc('created_at')->get();
        $messages = $ticket->messagesTicket()->orderByDesc('created_at')->get();
        $statuses = Status::all();
        $statusTicket = $ticket->latestTicketInformation->statusTicket->id;
        $ticketHistories = $ticket->historyTicket()->orderByDesc('created_at')->get();

        return view(
            'designer.showTicket',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories')
        );
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
