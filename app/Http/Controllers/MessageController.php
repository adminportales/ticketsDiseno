<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Message;
use App\Notifications\MessageNotification;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

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

        // Obtener el id del ticket, hay que traerlo del formulario
        $ticket = Ticket::find($request->ticket_id);

        // Obtener el id y nombre del vendedor y diseñador asignados al ticket
        // El diseñador transmite el mensaje y el vendedor recibe
        $transmitter_id = auth()->user()->id;
        $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        $userReceiver = '';
        if (auth()->user()->hasRole(['designer', 'design_manager'])) {
            $userReceiver = User::find($ticket->creator_id);
        } else if (auth()->user()->hasRole(['seller', 'sales_manager'])) {
            $userReceiver = User::find($ticket->designer_id);
        }
        $receiver_id = $userReceiver->id;
        $receiver_name = $userReceiver->name . ' ' . $userReceiver->lastname;
        // Guardar el mensaje con los sigioetes datos

        // Creamos el mensaje y lo guardamos en la base de datos
        $message = Message::create([
            "transmitter_id" => $transmitter_id,
            "transmitter_name" => $transmitter_name,
            'transmitter_role' => auth()->user()->whatRoles[0]->name,
            "receiver_id" => $receiver_id,
            "receiver_name" => $receiver_name,
            "message" => $request->message,
            "ticket_id" => $ticket->id
        ]);

        // Creamos un registro en el historial de logs
        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'reference_id' => $message->id,
            'type' => 'message'
        ]);
        //Mensaje
        event(new MessageSendEvent($message->message, $receiver_id, $transmitter_name));
        $userReceiver->notify(new MessageNotification($ticket->latestTicketInformation->title, $ticket->seller_name, $message->message));
        // Regresar a la misma vista AtenderTicket (ticket.show)
        if (auth()->user()->hasRole(['designer', 'design_manager'])) {
            return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
        } else if (auth()->user()->hasRole(['seller', 'sales_manager'])) {
            return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
        }
    }
}
