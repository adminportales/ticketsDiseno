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
        $userSeller = $role->whatUsers;

        //Traer el numero de asistentes
        $role = Role::find(6);
        $userAssitent = $role->whatUsers;

        $priorities = Priority::all();

        // Obtenemos los tickets que pertenecen a los vendedores de la empresa BH o PL,
        // Dependiendo de que gerente de ventas inicio sesion
        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.creator_id')
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
            $statusTicket = $ticket->latestStatusChangeTicket->status;
            if ($statusTicket == 'Finalizado') {
                $closedTickets++;
            } else {
                $openTickets++;
            }
            $totalTickets++;
        }
        $notifications = $user->unreadNotifications;
        //Retornar la vista
        return view('sales_manager.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets', 'notifications', 'userSeller', 'userAssitent','priorities'));
    }
    public function allTickets()
    {
        $priorities = Priority::all();

        $tickets_id = DB::table('users')
            ->join('tickets', 'users.id', '=', 'tickets.creator_id')
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
