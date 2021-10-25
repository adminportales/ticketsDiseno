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
        return redirect()->action('DesignerController@show', ['ticket' => $ticket->id]);
    }
}
