<?php

namespace App\Http\Controllers;

use App\Role;
use App\Ticket;
use App\Type;
use Illuminate\Http\Request;

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
    public function allTickets()
    {
        $role = Role::find(3);
        $designers = $role->whatUsers->makeHidden('pivot');;
        $tickets = Ticket::all();
        return view('design_manager.index', compact('tickets', 'designers'));
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
        $role = Role::find(3);
        $users = $role->whatUsers;
        return view('design_manager.ticketAssigment.index', compact('users'));
    }
}
