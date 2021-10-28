<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','role:admin']);
    }

    static function dashboard()
    {
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
        return view('administrador.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
}
