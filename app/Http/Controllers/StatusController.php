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
            return response()->json(['message' => 'OK'], 200);
        }
        return response()->json(['message' => 'Deny'], 400);
    }
}
