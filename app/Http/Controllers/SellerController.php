<?php

namespace App\Http\Controllers;

use App\Priority;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:seller']);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static function dashboard()
    {
        // traemos los tickets que el vendedor creo, traemos su estado
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        $assistant = auth()->user()->teamMember[0]->user;
        $ticketAssistant = $assistant->ticketsCreated;
        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;

        foreach ($tickets as $ticket) {
            $statusTicket = $ticket->latestStatusChangeTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }

        // Retornamos la vista
        return view('seller.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets', 'ticketAssistant', 'assistant'));
    }
}
