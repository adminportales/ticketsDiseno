<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Role;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\DB;

class SalesManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:sales_manager']);
    }

    static function dashboard()
    {
        $user = User::find(auth()->user()->id);

        //Traer el numero de vendedores (ejecutivos) y asistentes
        $role = Role::find(2);
        $userSeller = 0;
        $userAssitent = 0;
        $allTickets = [];
        foreach ($user->team->members as $userSelected) {
            $tickets = $userSelected->ticketsCreated()->where('status_id', '<', 6)->paginate(5);
            foreach ($tickets as $ticket) {
                array_push($allTickets, $ticket);
            }
            if ($userSelected->whatRoles[0]->name == 'seller') {
                $userSeller++;
            }
            if ($userSelected->whatRoles[0]->name == 'sales_assistant') {
                $userAssitent++;
            }
        }
        $priorities = Priority::all();

        $totalTickets = 0;
        // Contabilizar los tickets
        $totalTickets = 0;
        $closedTickets = 0;
        $openTickets = 0;

        foreach ($allTickets as $ticket) {
            $statusTicket = $ticket->latestStatusChangeTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }

        $tickets = $user->ticketsCreated()->where('status_id', '<', 6)->orderBy('priority_id', 'ASC')->orderBy('updated_at', 'ASC')->paginate(5);
        //Retornar la vista
        return view('sales_manager.dashboard', compact(
            'allTickets',
            'tickets',
            'totalTickets',
            'openTickets',
            'userSeller',
            'userAssitent',
            'priorities'
        ));
    }

    public function allTickets()
    {
        $priorities = Priority::all();
        $allTickets = [];
        foreach (auth()->user()->team->members as $userSelected) {
            $tickets = $userSelected->ticketsCreated()->where('status_id', '<', 6)->paginate(5);
            foreach ($tickets as $ticket) {
                array_push($allTickets, $ticket);
            }
        }
        $tickets = $allTickets;
        return view('sales_manager.allTickets', compact('tickets', 'priorities'));
    }
}
