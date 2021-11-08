<?php

namespace App\Http\Controllers;

use App\Events\ChangePrioritySendEvent;
use App\Notifications\ChangePriorityNotification;
use App\Priority;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class PriorityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Priority  $priority
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        if ($ticket->priority_id == $request->priority) {
            return response()->json('equalPriority');
        }
        $ticket->update([
            'priority_id' => $request->priority
        ]);
        $receiver = User::find($ticket->designer_id);
        $priority = Priority::find($request->priority);
        event(new ChangePrioritySendEvent($priority->priority, $ticket->latestTicketInformation->title, $ticket->designer_id, $ticket->seller_name));
        $receiver->notify(new ChangePriorityNotification($ticket->latestTicketInformation->title, $ticket->seller_name, $priority->priority));
        return response()->json($priority);
    }
}
