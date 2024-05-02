<?php

namespace App\Http\Controllers;

use App\Events\ChangeStatusSendEvent;
use App\Events\MessageSendEvent;
use App\Message;
use App\Notifications\ChangeOfStatus;
use App\Notifications\ChangeStatusNotification;
use App\Notifications\MessageNotification;
use App\Notifications\StatusTicket;
use App\Status;
use App\Ticket;
use App\TicketHistory;
use App\User;
use Exception;
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
            //dd($status->status);
            $statusChange = $ticket->statusChangeTicket()->create([
                'status_id' => $status->id,
                'status' => $status->status
            ]);
            $ticket->historyTicket()->create([
                'ticket_id' => $ticket->id,
                'reference_id' => $statusChange->id,
                'type' => 'status'
            ]);
            $ticket->status_id = $statusChange->status_id;
            $ticket->save();
            $transmitter_id = auth()->user()->id;
            $transmitter_name = auth()->user()->name . ' ' . auth()->user()->lastname;
            $userReceiver = '';
            if (auth()->user()->isAbleTo(['attend-ticket'])) {
                $userReceiver = User::find($ticket->creator_id);
            } else if (auth()->user()->isAbleTo(['create-ticket'])) {
                $userReceiver = User::find($ticket->designer_id);
            }
            $receiver_id = $userReceiver->id;
            $receiver_name = $userReceiver->name . ' ' . $userReceiver->lastname;

            try {
                event(new ChangeStatusSendEvent($ticket->latestTicketInformation->title, $status->status, $receiver_id, $transmitter_name));
                if ($receiver_id != 26) {
                    $userReceiver->notify(new ChangeOfStatus($ticket->id, $ticket->latestTicketInformation->title, $transmitter_name, $status->status));
                    if ($status->status == 'Realizando ajustes' || $status->status == 'Finalizado' || $status->status == 'Solicitar artes') {                        $userReceiver->notify(new StatusTicket($ticket->latestTicketInformation->title, $status->status, $transmitter_name, $ticket->id));
                    }
                }
            } catch (Exception $th) {
            }
            if ($request->message != '' && $request->status != 6) {
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
                try {
                    event(new MessageSendEvent($request->message, $receiver_id, $transmitter_name));
                    $userReceiver->notify(new MessageNotification($ticket->id, $ticket->latestTicketInformation->title, $transmitter_name, $message->message));
                    $userReceiver->notify(new StatusTicket($ticket->latestTicketInformation->title, $status->status, $transmitter_name, $ticket->id));
                } catch (Exception $th) {
                }
            }
            if ($request->images != '' && $request->status != 6) {

                $latestTicketInformation = $ticket->latestTicketInformation;

                $itemsComplete = [];
                $newDataItems = explode(',', $request->images);
                if ($latestTicketInformation->items != '' || $latestTicketInformation->items != null) {
                    $dataItems = explode(',', $latestTicketInformation->items);
                    $itemsComplete =  array_merge($dataItems, $newDataItems);
                } else {
                    $itemsComplete = $newDataItems;
                }
                $latestTicketInformation = $ticket->latestTicketInformation;
                $ticketInformation = $ticket->ticketInformation()->create([
                    'technique_id' => $latestTicketInformation->technique_id,
                    'customer' => $latestTicketInformation->customer,
                    'description' => $latestTicketInformation->description,
                    'modifier_name' => $latestTicketInformation->modifier_name,
                    'modifier_id' => $latestTicketInformation->modifier_id,
                    'title' => $latestTicketInformation->title,
                    'logo' => $latestTicketInformation->logo,
                    'items' => $latestTicketInformation->items,
                    'product' => $latestTicketInformation->product,
                    'items' => implode(',', $itemsComplete),
                    'pantone' => $latestTicketInformation->pantone,
                    'position' => $latestTicketInformation->position,
                    'companies' => $latestTicketInformation->companies,
                    'samples' => $latestTicketInformation->samples,
                    'measures' => $latestTicketInformation->measures,
                ]);
                $ticket->historyTicket()->create([
                    'ticket_id' => $ticket->id,
                    'reference_id' => $ticketInformation->id,
                    'type' => 'info'
                ]);
            }
            return response()->json(['message' => 'OK', 'status' => $status->status], 200);
        }
        return response()->json(['message' => 'Deny'], 400);
    }
}
