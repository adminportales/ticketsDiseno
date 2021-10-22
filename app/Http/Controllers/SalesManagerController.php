<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesManagerController extends Controller
{
    static function dashboard()
    {
        // Obtenemos los tickets que pertenecen a los vendedores de la empresa BH o PL,
        // Dependiendo de que gerente de ventas inicio sesion
        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.seller_id')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.company', '=', auth()->user()->profile->company)
            ->select('tickets.id')
            ->paginate(5);
        $tickets = [];

        foreach ($tickets_id as $ticket_id) {
            array_push($tickets, Ticket::find($ticket_id->id));
        }

        // Contabilizar los tickets
        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;

        foreach ($tickets as $ticket) {
            $statusTicket = $ticket->latestTicketInformation->statusTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }

        //Retornar la vista
        return view('sales_manager.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
    public function allTickets()
    {
        $priorities = Priority::all();

        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.seller_id')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.company', '=', auth()->user()->profile->company)
            ->select('tickets.id')
            ->paginate(5);
        $tickets = [];

        foreach ($tickets_id as $ticket_id) {
            array_push($tickets, Ticket::find($ticket_id->id));
        }

        return view('sales_manager.allTickets', compact('tickets', 'priorities'));
    }
}
