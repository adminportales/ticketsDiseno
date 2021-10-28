<?php

namespace App\Http\Controllers;

use App\Message;
use App\Status;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($request->status) {
            $status = Status::find($request->status);
            $statusChange = $ticket->statusChangeTicket()->create([
                'status_id' => $status->id,
                'status' => $status->status
            ]);
            $ticket->historyTicket()->create([
                'ticket_id' => $ticket->id,
                'reference_id' => $statusChange->id,
                'type' => 'status'
            ]);
            if ($request->message != '') {
                // Obtener el id y nombre del vendedor y diseñador asignados al ticket
                // El diseñador transmite el mensaje y el vendedor recibe
                $transmitter_id = auth()->user()->id;
                $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
                $userReceiver = '';
                if (auth()->user()->hasRole(['designer', 'design_manager'])) {
                    $userReceiver = User::find($ticket->designer_id);
                } else if (auth()->user()->hasRole(['seller', 'sales_manager'])) {
                    $userReceiver = User::find($ticket->seller_id);
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
            }
            return response()->json(['message' => 'OK'], 200);
        }


        return response()->json(['message' => 'Deny'], 400);
    }
}
