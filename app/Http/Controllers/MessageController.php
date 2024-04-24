<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Message;
use App\Notifications\MessageNotification;
use App\Notifications\MessageTicket;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

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
        $user  = auth()->user();
        // Obtener los datos del formulario de mensajes
        request()->validate([
            'message' => ['required', 'string'],
            'ticket_id' => ['required']
        ]);

        // Obtener el id del ticket, hay que traerlo del formulario
        $ticket = Ticket::find($request->ticket_id);

        $tic = DB::table('ticket_informations')->where('ticket_id', $request->ticket_id)->first();
        $ticket_title = $tic->title;

        // Obtener el id y nombre del vendedor y diseñador asignados al ticket
        // El diseñador transmite el mensaje y el vendedor recibe
        $transmitter_id = auth()->user()->id;
        $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        $userReceiver = '';
        /*     if (auth()->user()->isAbleTo(['attend-ticket'])) {
            $userReceiver = User::find($ticket->creator_id);
        } else if (auth()->user()->isAbleTo(['create-ticket'])) {
            $userReceiver = User::find($ticket->designer_id);
        } */
        /*     $user = User::where('id', $ticket->creator_id)->first();
        dd($user); */
        if (auth()->user()->isAbleTo(['attend-ticket'])) {
            $userReceiver = User::where('id', $ticket->creator_id)->first();
        } else if (auth()->user()->isAbleTo(['create-ticket'])) {
            $userReceiver = User::where('id', $ticket->designer_id)->first();
        }
        if ($userReceiver == null) {
            $receiver_id = null;
            $receiver_name = null;
        } else {

            // Guardar el mensaje con los sigioetes datos
            // Creamos el mensaje y lo guardamos en la base de datos


            $receiver_id = $userReceiver->id;
            $receiver_name = $userReceiver->name . ' ' . $userReceiver->lastname;
        }
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
        if ($receiver_id !== null) {
            try {
                event(new MessageSendEvent($message->message, $receiver_id, $transmitter_name));
                $userReceiver->notify(new MessageNotification($ticket->id, $ticket->latestTicketInformation->title, $transmitter_name, $message->message));
            } catch (Exception $th) {
            }
        }

        try {
            if ($userReceiver) {
                $userReceiver->notify(new MessageTicket($transmitter_name, $receiver_name, $ticket_title, $request->message));
            }
        } catch (\Exception $e) {
        }


        // Regresar a la misma vista AtenderTicket (ticket.show)
        if (auth()->user()->isAbleTo(['attend-ticket'])) {
            return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
        } else if (auth()->user()->isAbleTo(['create-ticket'])) {
            return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
        }
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return back();
    }
}
