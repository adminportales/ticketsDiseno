<?php

namespace App\Http\Controllers;

use App\Role;
use App\Ticket;
use App\Type;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class DesignerManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    static function dashboard()
    {
        $tickets = Ticket::all();

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

        return view('design_manager.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }

    //Metodo para ver todos los tickets
    public function index()
    {
        $tickets = Ticket::all();$tickets = Ticket::all();


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
        return view('design_manager.index', compact('totalTickets', 'tickets', 'openTickets', 'closedTickets'));
    }
    //Metodo para visualizar mis propios tickets
    public function verTickets()
    {
        $tickets = auth()->user()->assignedTickets;
        return view('design_manager.tickets')->with('tickets', $tickets);
    }

    //Metodo para asignar tickets
    public function ticketAssign()
    {
        $role= Role::find(3);
        $users= $role->whatUsers;

        return view('design_manager.assign', compact('users'));
    }


}