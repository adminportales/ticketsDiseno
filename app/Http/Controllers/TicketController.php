<?php

namespace App\Http\Controllers;

use App\Status;
use App\Technique;
use App\Ticket;
use App\TicketAssigment;
use App\TicketHistory;
use App\TicketInformation;
use App\Type;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

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
        //Validar quien esta en su qeuipo

        // Traer tickes que crearon los usuario que pertenecen a us qeuipo

        // Traer sus proios tickets

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
        return view('seller.tickets.index', compact('tickets', 'totalTickets', 'closedTickets', 'openTickets'));
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
        // Validar los datos
        request()->validate([
            'type' => 'required',
            'customer' => ['required', 'string', 'max:255'],
            'technique' => 'required',
            'description' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'logo' => 'required',
            'product' => 'required',
            'items' => 'required',
            'pantone' => 'required'
        ]);

        // Obtener el id y el nombre del vendedor
        $seller_id = auth()->user()->id;
        $seller_name = auth()->user()->name . ' ' . auth()->user()->lastname;

        //Asignar el ticket de forma correcta
        $designerAssigments = TicketAssigment::where('type_id', '=', $request->type)->get();
        $designerAssigment = '';
        if (count($designerAssigments) <= 0) {
            return back()->with('message', 'Aun no existen diseñadores que puedan atender tu solicitud! Contacta al gerente de diseño para solicitar una aclaracion!');
        }
        if (count($designerAssigments) == 1) {
            $designerAssigment = User::find($designerAssigments[0]->designer_id);
        } else {
            //verificar la carga de trabajo
            $designerAssigment = $this->checkWorkload($designerAssigments);
        }

        // Registrar el ticket
        $ticket = Ticket::create([
            'seller_id' => $seller_id,
            'seller_name' =>  $seller_name,
            'designer_id' => 8,
            'designer_name' => 'Edwin Samuel',
            'priority_id' => 1,
            'type_id' => $request->type
        ]);
        // Guardar las imagenes y obtener las rutas
        $ruta_imagen_producto = $request['product']->store('upload-tickets_producto', 'public');
        $ruta_imagen_logo = $request['logo']->store('upload-tickets_logo', 'public');
        // Registrar la informacion del ticket
        $ticketInformation = $ticket->ticketInformation()->create([
            'ticket_id' => $ticket->id,
            'status_id' => 1,
            'customer' => $request->customer,
            'technique' => $request->technique,
            'description' => $request->description,
            'title' => $request->title,
            'logo' => $request->logo,
            'items' => $request->items,
            'product' => $request->product,
            'items' => $request->items,
        ]);

        $ticket->historyTicket()->create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);

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
        $statusTicket = $ticket->latestTicketInformation->statusTicket->id;

        $ticketHistories = $ticket->historyTicket()->orderByDesc('created_at')->get();

        return view(
            'seller.tickets.show',
            compact('messages', 'ticketInformation', 'ticket', 'statuses', 'statusTicket', 'ticketHistories')
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
        $ticketInformation = $ticket->latestTicketInformation;
        return view('seller.tickets.edit', compact('ticket', 'types', 'ticketInformation'));
        //
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
        request()->validate([
            'customer' => ['required', 'string', 'max:255'],
            'technique' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'logo' => 'required|image',
            'product' => 'required|image',
            'pantone' => 'required'
        ]);

        // Guardar las imagenes y obtener las rutas
        $ruta_imagen_producto = $request['product']->store('upload-tickets_producto', 'public');
        $ruta_imagen_logo = $request['logo']->store('upload-tickets_logo', 'public');
        // Registrar la informacion del ticket
        $ticketInformation = TicketInformation::create(([
            'ticket_id' => $ticket->id,
            'status_id' =>  $ticket->latestTicketInformation->status_id,
            'customer' => $request->customer,
            'technique' => $request->technique,
            'description' => $request->description,
            'title' => $request->title,
            'logo' => $ruta_imagen_logo,
            'product' => $ruta_imagen_producto,
            'pantone' => $request->pantone,
        ]));

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);
        // Regresar a la vista de inicio
        return redirect()->action('HomeController@index');
    }

    public function uploadItems(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . rand(10, 100) . '.' . $imagen->extension();
        $imagen->move(public_path('storage/items'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteItem(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/items/' . $imagen)) {
                File::delete('storage/items/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function uploadProducts(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . rand(10, 100) . '.' . $imagen->extension();
        $imagen->move(public_path('storage/products'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteProduct(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/products/' . $imagen)) {
                File::delete('storage/products/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function uploadLogos(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time() . rand(10, 100) . '.' . $imagen->extension();
        $imagen->move(public_path('storage/logos'), $nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function deleteLogo(Request $request)
    {
        if ($request->ajax()) {
            $imagen = $request->get('imagen');

            if (File::exists('storage/logos/' . $imagen)) {
                File::delete('storage/logos/' . $imagen);
            }
            return response(['mensaje' => 'Imagen Eliminada', 'imagen' => $imagen], 200);
        }
    }

    public function checkWorkload($designerAssigments)
    {

        $data = [];
        // Crear un arreglo para guardar el total de tickets que no estan finalizados
        foreach ($designerAssigments as $key => $designerAssigment) {
            $designer = User::find($designerAssigment->designer_id);

            $totalTickets = 0;
            $timeWait = 0;

            foreach ($designer->assignedTickets as $ticket) {
                if ($ticket->latestTicketInformation->statusTicket->status != 'Finalizado') {
                    $totalTickets++;
                }
            }

            $data[$key] = [
                'designer' => $designer,
                'total' => $totalTickets,
                'time' => $timeWait,
            ];
        }

        //Verificar quien tiene el menor numero de tickets o si son iguales
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
