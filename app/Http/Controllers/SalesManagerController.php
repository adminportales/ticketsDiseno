<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Role;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
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

        //Traer el numero de vendedores (ejecutivos)
        $role = Role::find(2);
        $userSeller = 0;
        foreach ($role->whatUsers as $userSelected) {
            if ($userSelected->profile->company == $user->profile->company) {
                $userSeller++;
            }
        }

        //Traer el numero de asistentes
        $role = Role::find(6);
        $userAssitent = 0;
        foreach ($role->whatUsers as $userSelected) {
            if ($userSelected->profile->company == $user->profile->company) {
                $userAssitent++;
            }
        }

        $priorities = Priority::all();

        // Obtenemos los tickets que pertenecen a los vendedores de la empresa BH o PL,
        // Dependiendo de que gerente de ventas inicio sesion
        $allTickets_id = DB::table('tickets')
            ->join('users', 'users.id',  '=', 'tickets.creator_id')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->orderBy('tickets.priority_id', 'ASC')
            ->orderBy('tickets.created_at', 'ASC')
            ->where('tickets.creator_id', '!=', auth()->user()->id)
            ->where('profiles.company', '=', auth()->user()->profile->company)
            ->where('tickets.status_id', '<', '6')
            ->select('tickets.id')
            ->get();

        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.creator_id')
            ->where('tickets.creator_id', '=', auth()->user()->id)
            ->orderBy('tickets.priority_id', 'ASC')
            ->orderBy('tickets.created_at', 'ASC')
            ->where('tickets.status_id', '<', '6')
            ->select('tickets.id')
            ->paginate(5);

        $tickets = [];
        $allTickets = [];

        $totalTickets = 0;

        foreach ($allTickets_id as $ticket_id) {
            array_push($allTickets, Ticket::find($ticket_id->id));
        }
        foreach ($tickets_id as $ticket_id) {
            array_push($tickets, Ticket::find($ticket_id->id));
        }
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

        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.creator_id')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('profiles.company', '=', auth()->user()->profile->company)
            ->select('tickets.id')
            ->get();
        $tickets = [];

        foreach ($tickets_id as $ticket_id) {
            array_push($tickets, Ticket::find($ticket_id->id));
        }

        return view('sales_manager.allTickets', compact('tickets', 'priorities'));
    }
}
