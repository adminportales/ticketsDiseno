<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketDelivery;
use App\TicketHistory;
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


        $statusChange = $ticket->latestTicketInformation;
        $status = 0;

        if ($ticket->latestTicketInformation->status_id == 2) {
            $status = 3;
        } else if ($ticket->latestTicketInformation->status_id == 5) {
            $status = 6;
        } else {
            $status = $statusChange->status_id;
        }
        if ($status != $statusChange->status_id) {
            $ticketInformation = $ticket->ticketInformation()->create([
                'status_id' => $status,
                'technique_id' => $statusChange->technique_id,
                'customer' => $statusChange->customer,
                'description' => $statusChange->description,
                'modifier_name' => $statusChange->modifier_name,
                'modifier_id' => $statusChange->modifier_id,
                'title' => $statusChange->title,
                'logo' => $statusChange->logo,
                'items' => $statusChange->items,
                'product' => $statusChange->product,
                'items' => $statusChange->items,
                'pantone' => $statusChange->pantone,
            ]);
            $ticket->historyTicket()->create([
                'ticket_id' => $ticket->id,
                'reference_id' => $ticketInformation->id,
                'type' => 'info'
            ]);
        }

        return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
    }
}
