<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        $userReceiver = User::find($ticket->designer_id);
        $receiver_id = $userReceiver->id;
        $receiver_name = $userReceiver->name . ' ' . $userReceiver->lastname;
        // Guardar el mensaje con los sigioetes datos

        $message = Message::create([
            "transmitter_id" => $transmitter_id,
            "transmitter_name" => $transmitter_name,
            'transmitter_role' => auth()->user()->whatRoles[0]->name,
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
        return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
    }
}
