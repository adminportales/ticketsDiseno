<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Revisar el rol de el usuario y si no tiene asignado ninguno, enviarlo al hobe
        if (auth()->user()->hasRole('seller')) {

            return $this->indexSeller();
        }

        if (auth()->user()->hasRole('designer')) {

            return $this->indexDesigner();
        }

        if (auth()->user()->hasRole('admin')) {

            return $this->indexAdministrador();
        }

        if (auth()->user()->hasRole('sales_manager')) {

            return $this->indexSalesManager();
        }

        if (auth()->user()->hasRole('design_manager')) {

            return $this->indexDesignerManager();
        }
        return view('home');
    }

    // Retorna la vista inactivo en caso de que el usuario haya sido eliminado
    public function userActive()
    {
        return view('inactive');
    }

    public function indexAdministrador()
    {
        // Traemos el total de los tickets
        $tickets = Ticket::all();

        // Revisamos el estado de tickets
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

        // R4egresamos la vista
        return view('administrador.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }

    public function indexSeller()
    {
        // traemos los tickets que el vendedor creo, traemos su estado
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

        // Retornamos la vista
        return view('seller.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }

    public function indexDesigner()
    {
        // Leemos los tickets que se asignaron al ususrio y obtenemos su estado
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

        // MOstramos la vista
        return view('designer.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }

    public function indexSalesManager()
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

    public function indexDesignerManager()
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

        return view('design_manager.dashboard', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
    }
}
