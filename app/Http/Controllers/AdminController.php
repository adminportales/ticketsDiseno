<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    static function dashboard()
    {
        $user = User::where('status', 1)->count();
        $users = User::join('permission_user', 'users.id', '=', 'permission_user.user_id')->where('users.status', 1)->where('permission_user.permission_id', 1)->get();
        $usersDesigners = User::join('permission_user', 'users.id', '=', 'permission_user.user_id')->where('users.status', 1)->where('permission_user.permission_id', 2)->get();
        // Traemos el total de los tickets
        $tickets = Ticket::where('created_at', '>', now()->subMonth())->get();
        $dataTypeTickets = [];

        $virtual = 0;
        $presentacion = 0;
        $especial = 0;
        foreach ($tickets as $ticket) {
            switch ($ticket->type_id) {
                case 1:
                    // dd($ticket->type_id);
                    $virtual++;
                    break;
                case 2:
                    $presentacion++;
                    break;
                case 3:
                    // dd($ticket->type_id);
                    $especial++;
                    break;
                default:
                    # code...
                    break;
            }
        }
        $dataTypeTickets = [$virtual, $presentacion, $especial];

        // Estado de los tickets
        $dataStatus = [0, 0, 0, 0, 0, 0];
        $dataNameStatus = Status::all()->pluck('status')->toArray();
        foreach ($tickets as $ticket) {
            switch ($ticket->status_id) {
                case 1:
                    $dataStatus[0]++;
                    break;
                case 2:
                    $dataStatus[1]++;
                    break;
                case 3:
                    $dataStatus[2]++;
                    break;
                case 4:
                    $dataStatus[3]++;
                    break;
                case 5:
                    $dataStatus[4]++;
                    break;
                case 6:
                    $dataStatus[5]++;
                    break;
                default:
                    # code...
                    break;
            }
        }
        array_pop($dataNameStatus);
        array_pop($dataStatus);
        $dataInfoStatus = [$dataNameStatus, $dataStatus];


        // Vendedores
        $dataUserCreatedTickets = [];
        $dataUserCountTickets = [];
        $dataUserWithoutTickets = [];

        foreach ($users as $userCount) {
            $ticketsCreated = $userCount->ticketsCreated()->where('created_at', '>', now()->subMonth())->count();
            if ($ticketsCreated > 0) {
                array_push($dataUserCreatedTickets, $userCount->name);
                array_push($dataUserCountTickets, $ticketsCreated);
            } else {
                array_push($dataUserWithoutTickets, $userCount->name . ' ' . $userCount->lastname);
            }
        }
        $dataUserInfoTickets = [$dataUserCreatedTickets, $dataUserCountTickets, $dataUserWithoutTickets];

        // Dise単adores
        $dataUserCreatedTicketsDesign = [];
        $dataUserCountTicketsDesigns = [];

        foreach ($usersDesigners as $userCount) {
            $ticketsCreated = 0;
            foreach ($userCount->assignedTickets()->where('created_at', '>', now()->subMonth())->get() as $ticketAssigned) {
                // dd($ticketAssigned->designer_name);s
                if (strpos($ticketAssigned->designer_name, $userCount->name) !== false) {
                    $ticketsCreated++;
                }
            }
            if ($ticketsCreated > 0) {
                array_push($dataUserCreatedTicketsDesign, $userCount->name);
                array_push($dataUserCountTicketsDesigns, $ticketsCreated);
            }
        }
        $dataUserInfoTicketsDesign = [$dataUserCreatedTicketsDesign, $dataUserCountTicketsDesigns];

        // Regresamos la vista
        return view('administrador.dashboard', compact('tickets', 'user', 'dataTypeTickets', 'dataUserInfoTickets', 'dataUserInfoTicketsDesign', 'dataInfoStatus'));
    }

    public function viewTickets()
    {
        $tickets = Ticket::orderByDesc('created_at')->get();
        $priorities = Priority::all();

        return view('administrador.tickets.index', compact('tickets', 'priorities'));
    }
}
