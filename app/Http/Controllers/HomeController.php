<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use TicketSeeder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->hasRole('seller')) {

            return $this->indexSeller();
        }

        if (auth()->user()->hasRole('designer')) {

            return $this->indexDesigner();
        }

        if (auth()->user()->hasRole('admin')) {

            return $this->indexAdministrador();
        }

        if (auth()->user()->hasRole('saler_manager')) {

            return $this->indexSalerManager();
        }

        if (auth()->user()->hasRole('saler_design')) {

            return $this->indexSalerDesigner();
        }
        return view('home');
    }

    public function userActive()
    {
        return view('inactive');
    }
    public function indexSeller()
    {
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();

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
        return view('seller.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
    public function indexDesigner()
    {
        $tickets = auth()->user()->assignedTickets;

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

        return view('designer.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
    public function indexAdministrador()
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

        return view('administrador.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
    /*public function indexSalerManager()
    {
        return view('gerente_ventas.inicio_gerenteventas');
    }
    public function indexSalerDesigner()
    {
        return view ('gerentediseño.inicio_gerente_diseño');
    }*/
}
