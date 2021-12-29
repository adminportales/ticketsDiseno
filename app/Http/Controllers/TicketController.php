<?php

namespace App\Http\Controllers;

use App\Events\ChangeTicketSendEvent;
use App\Events\TicketCreateSendEvent;
use App\Notifications\TicketCreateNotification;
use App\Priority;
use App\Role;
use App\Status;
use App\Technique;
use App\Ticket;
use App\TicketAssigment;
use App\Type;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use ZipArchive;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*         $user = User::find(auth()->user()->id);
        // Obtener los tickets del vendedor y de su asistente
        // Si es vendedor, quien es my asistente y si es asistente, a quien asiste
        // $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        $ticketsAll = '';
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        if ($user->hasRole('sales_assistant')) {
            $members = $user->team->members;
            foreach ($members as $member) {
                dd($member->ticketsCreated);
                $ticketsAll = $member->ticketsCreated->union($tickets);
            }
        } else {
        }
        dd($ticketsAll);
        return; */
        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        // Obtener los ticktes del asistente y se sus ejecutivos

        $tickets = auth()->user()->ticketsCreated()->orderByDesc('created_at')->get();
        $priorities = Priority::all();

        return view('seller.tickets.index', compact('tickets', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $techniques = Technique::all();
        return view('seller.tickets.create', compact('types', 'techniques'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Obtener el id y el nombre del vendedor o asistente que esta editando
        $userCreator = User::find(auth()->user()->id);
        $creator_id = $userCreator->id;
        $creator_name = $userCreator->name . ' ' . $userCreator->lastname;
        request()->validate([
            'type' => 'required',
            'title' => ['required', 'string', 'max:255'],
            'link' => 'required',
        ]);

        switch ($request->type) {
            case 1:
                request()->validate([
                    'type' => 'required',
                    'technique' => 'required',
                    'position' => 'required',
                    'pantone' => 'required',
                    'description' => ['required', 'string'],
                    'logo' => 'required',
                    'product' => 'required',
                    'position' => 'required',
                ]);
                $request->items = null;
                $request->companies = null;
                $request->customer = null;
                break;
            case 2:
                request()->validate([
                    'type' => 'required',
                    'customer' => ['required', 'string', 'max:255'],
                    'companies' => 'required',
                    'description' => ['required', 'string'],
                    'logo' => 'required',
                    'items' => 'required',
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                break;
            case 3:
                request()->validate([
                    'type' => 'required',
                    'description' => ['required', 'string'],
                    'items' => 'required',
                ]);
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->customer = null;
                $request->companies = null;
                break;
            default:
                break;
        }

        // Si es un asistente, validacion extra y obtener el ejecutivo, y si no
        // El ejecutivo es el creador
        $seller_id = '';
        $seller_name = '';
        if ($userCreator->hasRole('sales_assistant')) {
            request()->validate([
                'executive' => 'required',
            ]);
            $seller = User::find($request->executive);
            $seller_id = $seller->id;
            $seller_name = $seller->name . ' ' . $seller->lastname;
        } else {
            $seller_id = $userCreator->id;
            $seller_name = $userCreator->name . ' ' . $userCreator->lastname;
        }


        //Asignar el ticket de forma correcta
        $designerAssigments = TicketAssigment::where('type_id', '=', $request->type)->get();
        // Algoritmo para la asignacion de tickets
        $designerAssigment = $this->checkWorkload($designerAssigments);

        // Registrar el ticket
        $ticket = Ticket::create([
            'creator_id' => $creator_id,
            'creator_name' =>  $creator_name,
            'seller_id' => $seller_id,
            'seller_name' =>  $seller_name,
            'designer_id' => $designerAssigment->id,
            'designer_name' => $designerAssigment->name . ' ' . $designerAssigment->lastname,
            'priority_id' => 2,
            'type_id' => $request->type,
            'status_id' => 1
        ]);
        // Creacion del estado
        $status = Status::find(1);
        $statusChange = $ticket->statusChangeTicket()->create([
            'status_id' => $status->id,
            'status' => $status->status
        ]);

        // Registrar la informacion del ticket
        if ($request->companies) {
            $request->companies = implode(',', $request->companies);
        }
        $ticketInformation = $ticket->ticketInformation()->create([
            'technique_id' => $request->technique,
            'customer' => $request->customer,
            'description' => $request->description,
            'modifier_name' => $creator_name,
            'modifier_id' => $creator_id,
            'title' => $request->title,
            'logo' => $request->logo,
            'items' => $request->items,
            'product' => $request->product,
            'pantone' => $request->pantone,
            'position' => $request->position,
            'companies' => $request->companies,
            'link' => $request->link,
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $statusChange->id,
            'type' => 'status'
        ]);

        // Notificacion para avisar al diseñador
        event(new TicketCreateSendEvent($ticket->latestTicketInformation->title, $ticket->designer_id, $ticket->creator_name));
        $designerAssigment->notify(new TicketCreateNotification($ticket->latestTicketInformation->title, $ticket->creator_name));

        // Regresar a la vista de inicio
        return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $ticketInformation = $ticket->ticketInformation()->orderByDesc('created_at')->get();
        $messages = $ticket->messagesTicket()->orderByDesc('created_at')->get();
        $statuses = Status::all();
        $statusTicket = $ticket->latestStatusChangeTicket->status;

        $ticketHistories = $ticket->historyTicket;
        $ticketDeliveries = $ticket->deliveryTicket;

        return view(
            'seller.tickets.show',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories', 'ticketDeliveries')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $types = Type::all();
        $techniques = Technique::all();
        $ticketInformation = $ticket->latestTicketInformation;
        return view('seller.tickets.edit', compact('techniques', 'ticket', 'types', 'ticketInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Obtener el id y el nombre del vendedor o asistente que esta editando
        $userCreator = User::find(auth()->user()->id);
        $creator_id = $userCreator->id;
        $creator_name = $userCreator->name . ' ' . $userCreator->lastname;

        request()->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);
        switch ($ticket->typeTicket->id) {
            case 1:
                request()->validate([
                    'technique' => 'required',
                    'position' => 'required',
                    'pantone' => 'required',
                    'description' => ['required', 'string'],
                ]);
                $request->logo = $request->logo == null ?  $ticket->latestTicketInformation->logo : $request->logo;
                $request->product = $request->product == null ? $ticket->latestTicketInformation->product : $request->product;
                $request->items = null;
                $request->companies = null;
                $request->customer = null;
                break;
            case 2:
                request()->validate([
                    'customer' => ['required', 'string', 'max:255'],
                    'companies' => 'required',
                    'description' => ['required', 'string'],
                ]);
                $request->logo = $request->logo == null ?  $ticket->latestTicketInformation->logo : $request->logo;
                $request->items = $request->items == null ?  $ticket->latestTicketInformation->items : $request->items;
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                break;
            case 3:
                request()->validate([
                    'description' => ['required', 'string'],
                ]);
                $request->items = $request->items == null ?  $ticket->latestTicketInformation->items : $request->items;
                $request->product = null;
                $request->pantone = null;
                $request->technique = null;
                $request->position = null;
                $request->logo = null;
                $request->customer = null;
                $request->companies = null;
                break;
            default:
                break;
        }

        // Registrar la informacion del ticket
        if ($request->companies) {
            $request->companies = implode(',', $request->companies);
        }
        $ticketInformation = $ticket->ticketInformation()->create([
            'technique_id' => $request->technique,
            'customer' => $request->customer,
            'description' => $request->description,
            'modifier_name' => $creator_name,
            'modifier_id' => $creator_id,
            'title' => $request->title,
            'logo' => $request->logo,
            'items' => $request->items,
            'product' => $request->product,
            'items' => $request->items,
            'pantone' => $request->pantone,
            'position' => $request->position,
            'companies' => $request->companies,
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);
        $receiver = User::find($ticket->designer_id);
        event(new ChangeTicketSendEvent($ticket->latestTicketInformation->title, $ticket->designer_id, $ticket->creator_name));
        $receiver->notify(new TicketCreateNotification($ticket->latestTicketInformation->title, $ticket->creator_name));
        // Regresar a la vista de inicio
        return redirect()->action('TicketController@show', ['ticket' => $ticket->id]);
    }

    public function uploadDeliveries(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . ' ' . str_replace(',', ' ', $imagen->getClientOriginalName());
        $imagen->move(public_path('storage/deliveries'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteDelivery(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/deliveries/' . $imagen)) {
                File::delete('storage/deliveries/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function checkWorkload($designerAssigments)
    {
        /*
           Revisar si hay cero diseñadores que pueden recibir este tipo de ticket
           En este caso asignarlo al gerente de diseño y que el lo reasigne si desea
        */
        if (count($designerAssigments) <= 0) {
            $designer = Role::find(5)->whatUsers;
            return $designer[0];
        }
        /*
            Si solo hay un diseñador que recibe ese ticket, asignar el ticket a ese diseñador
            Si no esta disponible por que falto o algo, asignarselo al gerente de diseño
        */
        if (count($designerAssigments) == 1) {
            $designerAssigment = User::find($designerAssigments[0]->designer_id);
            if ($designerAssigment->profile->availability) {
                return $designerAssigment;
            } else {
                $designer = Role::find(5)->whatUsers;
                return $designer[0];
            }
        } else {
            /*
                Si hay mas de un diseñador que pueda atender este ticket
                Revisamos las disponibilidad
            */
            $data = [];
            // Crear un arreglo para guardar el total de tickets que no estan finalizados
            foreach ($designerAssigments as $key => $designerAssigment) {
                $designer = User::find($designerAssigment->designer_id);

                $totalTickets = 0;
                $timeWait = 0;
                // Vamos a considerar al diseñador siempre y cuando este disponible
                if ($designer->profile->availability) {
                    foreach ($designer->assignedTickets as $ticket) {
                        if ($ticket->latestStatusChangeTicket->status != 'Finalizado') {
                            $totalTickets++;
                        }
                    }
                    $data[$key] = [
                        'designer' => $designer,
                        'total' => $totalTickets,
                        'time' => $timeWait,
                    ];
                }
            }

            // Si no hay diseñadores disponibles, se asignan al gerente de diseño
            if (count($data) <= 0) {
                $designer = Role::find(5)->whatUsers;
                return $designer[0];
            }

            //Verificar quien tiene el menor numero de tickets o si son iguales
            $data = array_values($data);
            $designerAssigment = $data[0];
            $sameAmountOfVirtual = true;
            foreach ($data as $key => $item) {
                if ($item['total'] < $designerAssigment['total']) {
                    $designerAssigment = $item;
                    $sameAmountOfVirtual = false;
                }
            }

            //Si el numero de tickets es el mismo, asignalos aleatoreamemte
            //Si no, regresa el que tenga el menor numero de tickets asignados
            if (!$sameAmountOfVirtual) {
                return $designerAssigment['designer'];
            } else {
                return $data[rand(0, count($data) - 1)]['designer'];
            }
        }
    }

    //Comprimir archivos de ticket y descargarlos
    public function descargarArchivos(Ticket $ticket)
    {
        $public_dir = public_path('storage/zip');
        $zipFileName = $ticket->latestTicketInformation->title . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            if ($ticket->latestTicketInformation->product) {
                $zip->addFile(public_path('storage/products/' . $ticket->latestTicketInformation->product), $ticket->latestTicketInformation->product);
            }
            if ($ticket->latestTicketInformation->logo) {
                $zip->addFile(public_path('storage/logos/' . $ticket->latestTicketInformation->logo), $ticket->latestTicketInformation->logo);
            }
            if ($ticket->latestTicketInformation->items) {
                foreach (explode(',', $ticket->latestTicketInformation->items) as $item) {
                    $zip->addFile(public_path('storage/items/' . $item), $item);
                }
            }
            $zip->close();
        }

        // Set Header
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath = $public_dir . '/' . $zipFileName;
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers);
        }
    }
}
