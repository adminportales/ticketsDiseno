<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\Ticket;
use App\Type;
use App\User;
use Illuminate\Http\Request;

class DesignerManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:design_manager']);
    }

    static function dashboard()
    {
        $tickets = Ticket::where('designer_id', '!=', auth()->user()->id)->where('status_id', '!=', 6)->where('status_id', '!=', 3)->orderBy('created_at','desc')->limit(5)->get();
        $ticketsPropios = auth()->user()->assignedTickets()->where('status_id', '!=', 6)->where('status_id', '!=', 3)->orderBy('created_at','desc')->limit(5)->get();
        $permission = Permission::find(2);
        $designers = $permission->users()->where('status', 1)->get();
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

        $ticketsToTransferMe = auth()->user()->latestTicketsToTransferMe()->where('status', 'En proceso de traspaso')->select("ticket_id")->get();
        $ticketsToTransfer = Ticket::whereIn('id', $ticketsToTransferMe)->orderByDesc('created_at')->get();

        return view('design_manager.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets', 'designers', 'ticketsPropios' , 'ticketsToTransfer'));
    }

    //Metodo para ver todos los tickets
    public function allTickets()
    {
        return view('design_manager.index');
    }
    //Metodo para visualizar mis propios tickets
    public function verTickets()
    {
        $tickets = auth()->user()->assignedTickets()->orderByDesc('created_at')->get();
        return view('design_manager.tickets')->with('tickets', $tickets);
    }

    //Metodo para asignar tickets por defecto
    public function ticketAssign()
    {
        $permission = Permission::find(2);
        $users = $permission->users()->where('status', 1)->get();
        return view('design_manager.ticketAssigment.index', compact('users'));
    }
}
