<?php

namespace App\Http\Controllers;

use App\Events\ChangeStatusSendEvent;
use App\Events\MessageSendEvent;
use App\Events\TicketDeliverySendEvent;
use App\Notifications\ChangeStatusNotification;
use App\Notifications\TicketDeliveryNotification;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class TicketDeliveryController extends Controller
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
    public function store(Request $request, Ticket $ticket)
    {
        request()->validate([
            'delivery' => 'required',
        ]);

        $ticketDelivery =  $ticket->deliveryTicket()->create([
            'designer_id' => auth()->user()->id,
            'designer_name' => auth()->user()->name . ' ' . auth()->user()->lastname,
            'is_accepted' => 0,
            'files' => request()->delivery
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketDelivery->id,
            'type' => 'delivery'
        ]);
        $userReceiver = User::find($ticket->creator_id);
        event(new TicketDeliverySendEvent($ticket->latestTicketInformation->title, $ticket->creator_id, $ticket->designer_name));
        $userReceiver->notify(new TicketDeliveryNotification($ticket->id, $ticket->latestTicketInformation->title, $ticket->designer_name));

        $status = 0;

        if ($ticket->latestStatusChangeTicket->status_id == 2) {
            $status = 3;
        } else if ($ticket->latestStatusChangeTicket->status_id == 5) {
            $status = 3;
        } else {
            $status = $ticket->latestStatusChangeTicket->status_id;
        }

        if ($status != $ticket->latestStatusChangeTicket->status_id) {
            $newStatus = Status::find($status);
            $status = $ticket->statusChangeTicket()->create([
                'status_id' => $newStatus->id,
                'status' => $newStatus->status,
            ]);
            $ticket->status_id = $newStatus->id;
            $ticket->save();
            $ticket->historyTicket()->create([
                'ticket_id' => $ticket->id,
                'reference_id' => $status->id,
                'type' => 'status'
            ]);
            $userReceiver = User::find($ticket->creator_id);
            // event(new ChangeStatusSendEvent($ticket->latestTicketInformation->title, $newStatus->status, $ticket->creator_id, $ticket->designer_name));
            // $userReceiver->notify(new ChangeStatusNotification($ticket->id, $ticket->latestTicketInformation->title, $ticket->seller_name, $newStatus->status));
        }
        return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
    }
}
