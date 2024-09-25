<?php

namespace App\Http\Controllers;

use App\HistoryAvailability;
use App\Priority;
use App\Role;
use App\SatisfactionModel;
use App\Status;
use App\Ticket;
use App\TicketStatusChange;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|design_manager']);
    }

    static function dashboard()
    {
        $user = User::where('status', 1)->count();
        $users = User::join('permission_user', 'users.id', '=', 'permission_user.user_id')->where('users.status', 1)->where('permission_user.permission_id', 1)->get();
        $usersDesigners = User::join('permission_user', 'users.id', '=', 'permission_user.user_id')->where('users.status', 1)->where('permission_user.permission_id', 2)->get();
        // Traemos el total de los tickets
        $tickets = Ticket::where('created_at', '>', now()->subMonths(2))->get();
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
            $ticketsCreated = $userCount->ticketsCreated()->where('created_at', '>', now()->subMonths(2))->count();
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
            foreach ($userCount->assignedTickets()->where('created_at', '>', now()->subMonths(2))->get() as $ticketAssigned) {
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

        // Entregas realizadas en los ultimos 7 dias
        $dias = 60;

        $dataUserDeliveredTickets = [];
        $daysChartTicketDeliveries = [];
        for ($i = $dias; $i >= 0; $i--) {
            $daysChartTicketDeliveries[] = now()->subDays($i)->format('d-m');
        }
        foreach ($usersDesigners as $userCount) {
            $ticketsDeliveries = [];
            for ($i = $dias; $i >= 0; $i--) {
                $ticketsDeliveries[] = ($userCount->deliveries()->whereDate("created_at", '=', now()->subDays($i)->format('Y-m-d'))->count());
            }
            $dataUserDeliveredTickets[] = [
                'name' => $userCount->name,
                'data' => $ticketsDeliveries
            ];
        }

        $dataDeliveries = [$daysChartTicketDeliveries, $dataUserDeliveredTickets];

        // Entregas realizadas por tipo de ticket
        $dataTypeDeliveredTickets = [];
        $daysChartTypeTicketDeliveries = [];
        for ($i = $dias; $i >= 0; $i--) {
            $daysChartTypeTicketDeliveries[] = now()->subDays($i)->format('d-m');
        }
        $typesTickets = Type::all();
        foreach ($typesTickets as $typeTicket) {
            $ticketsDeliveries = [];
            for ($i = $dias; $i >= 0; $i--) {
                $ticketsDeliveries[] = ($typeTicket->tickets()->whereDate("created_at", '=', now()->subDays($i)->format('Y-m-d'))->count());
            }
            $dataTypeDeliveredTickets[] = [
                'name' => $typeTicket->type,
                'data' => $ticketsDeliveries
            ];
        }
        $dataTypeDelivered = [$daysChartTypeTicketDeliveries, $dataTypeDeliveredTickets];


        // Recepcion de tickets
        $dataUserReceivedTickets = [];
        $daysChartTicketReceived = [];
        for ($i = $dias; $i >= 0; $i--) {
            $daysChartTicketReceived[] = now()->subDays($i)->format('d-m');
        }
        foreach ($usersDesigners as $userCount) {
            $ticketsReceived = [];
            for ($i = $dias; $i >= 0; $i--) {
                $ticketsReceived[] = ($userCount->assignedTickets()->whereDate("created_at", '=', now()->subDays($i)->format('Y-m-d'))->count());
            }
            $dataUserReceivedTickets[] = [
                'name' => $userCount->name,
                'data' => $ticketsReceived
            ];
        }
        $dataTicketsReceived = [$daysChartTicketReceived, $dataUserReceivedTickets];
        // Regresamos la vista

        return view('administrador.dashboard', compact('tickets', 'user', 'dataTypeTickets', 'dataUserInfoTickets', 'dataUserInfoTicketsDesign', 'dataInfoStatus', 'dataDeliveries', 'dataTypeDelivered', 'dataTicketsReceived'));
    }

    public function viewTickets()
    {
        $this->middleware('role:admin');

        $priorities = Priority::all();
        $tickets = Ticket::orderByDesc('created_at')->paginate(20);
        $ticketIds = $tickets->pluck('id');

        // Obtener los registros de ticket_status_changes relacionados con los IDs de los tickets
        foreach ($tickets as $ticket) {
            $ticket->statusChanges = TicketStatusChange::where('ticket_id', $ticket->id)
                ->where('status', 'Finalizado')
                ->orderByDesc('id')
                ->get();
            // Verificar si se encontraron cambios de estado con 'Entregado'
            if ($ticket->statusChanges->isEmpty()) {
                $ticket->statusChanges = ['Revisar status del ticket'];
            }
        }

        //dd($tickets);

        return view('administrador.tickets.index', compact('tickets', 'priorities'));
    }
    public function viewEncuestas()
    {
        // Obtenemos todos los diseñadores con el rol especificado y con estado activo
        $user_designers = Role::find(3)->whatUsers->where('status', 1);

        $info = [];

        foreach ($user_designers as $designer) {
            $designerName = $designer->name . ' ' . $designer->lastname;
            // Obtenemos todas las satisfacciones para el diseñador actual
            $satisfactions = SatisfactionModel::where('designer', $designerName)->get();

            if ($satisfactions->isNotEmpty()) {
                $tickets = [];
                $malas = 0;
                $neutrales = 0;
                $buenas = 0;

                foreach ($satisfactions as $satisfaction) {
                    $tickets[] = $satisfaction->ticket_id;

                    if ($satisfaction->answer == 'mal') {
                        $malas++;
                    } elseif ($satisfaction->answer == 'neutral') {
                        $neutrales++;
                    } elseif ($satisfaction->answer == 'bien') {
                        $buenas++;
                    }
                }

                $dataSatisfaction = [
                    'diseñador' => $designerName,
                    'tickets' => count($tickets),
                    'mal' => $malas,
                    'neutral' => $neutrales,
                    'buena' => $buenas,
                ];

                $info[] = $dataSatisfaction;
            }
        }

        return view('administrador.tickets.encuestas', compact('user_designers', 'info'));
    }
    /*  public function Encuestas()
    {

        return view('designer.listEncuesta', compact('user_designers', 'info'));
    } */
    public function viewHistory()
    {
        $history = HistoryAvailability::orderByDesc('created_at')->paginate(30);
        return view('administrador.history', compact('history'));
    }
}
