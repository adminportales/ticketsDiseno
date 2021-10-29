<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Priority;
use App\Ticket;
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
        event(new MessageSendEvent('Prioridad Cambiada', $ticket->designer_id, $ticket->designer_name));
        $priority = Priority::find($request->priority);
        return response()->json($priority);
    }
}
