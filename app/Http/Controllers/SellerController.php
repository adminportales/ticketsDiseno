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
        $tickets = auth()->user()->ticketsCreated()->where('status_id', '!=', 6)->orderByDesc('created_at')->paginate(5);
        $assistant = [];
        $ticketAssistant = [];
        $ticketsSellers = [];
        if (count(auth()->user()->teamMember) > 0) {
            $assistant = auth()->user()->teamMember[0]->user;
            $ticketAssistant = $assistant->ticketsCreated()->where('seller_id', '=', auth()->user()->id)->where('status_id', '!=', 6)->paginate(5);
        } else if (auth()->user()->team) {
            $members = auth()->user()->team->members ?  auth()->user()->team->members : 0;
            foreach ($members as $member) {
                $ticketsMember = [
                    'seller' => $member,
                    'tickets' => $member->ticketsCreated()->where('status_id', '!=', 6)->paginate(5)
                ];
                array_push($ticketsSellers, $ticketsMember);
            }
        }
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
        return view('seller.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets', 'ticketAssistant', 'assistant', 'ticketsSellers'));
    }
}
