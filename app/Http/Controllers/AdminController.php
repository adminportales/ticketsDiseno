<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','role:admin']);
    }

    static function dashboard()
    {
        $user = User::all();
        // Traemos el total de los tickets
        $tickets = Ticket::all();

        // Revisamos el estado de tickets
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

        // R4egresamos la vista
        return view('administrador.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets', 'user'));
    }

    public function viewTickets()
    {
        $tickets = Ticket::orderByDesc('created_at')->get();
        $priorities = Priority::all();

        return view('seller.tickets.index', compact('tickets', 'priorities'));
    }
}
