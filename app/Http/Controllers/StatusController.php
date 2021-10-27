<?php

namespace App\Http\Controllers;

use App\Status;
use App\Ticket;
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
            $statusChange = $ticket->latestTicketInformation;

            $ticketInformation = $ticket->ticketInformation()->create([
                'status_id' => 2,
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
            return response()->json(['message' => 'OK'], 200);
        }
        return response()->json(['message' => 'Deny'], 400);
    }
}
