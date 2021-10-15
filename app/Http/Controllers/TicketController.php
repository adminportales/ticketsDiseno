<?php

namespace App\Http\Controllers;

use App\Status;
use App\Ticket;
use App\TicketHistory;
use App\TicketInformation;
use App\Type;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('seller.tickets.create', compact('types'));
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
            'technique' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'logo' => 'required|image',
            'product' => 'required|image',
            'pantone' => 'required'
        ]);

        // Obtener el id y el nombre del vendedor
        $seller_id = auth()->user()->id;
        $seller_name = auth()->user()->name . ' ' . auth()->user()->lastname;

        // Registrar el ticket
        $ticket = Ticket::create([
            'seller_id' => $seller_id,
            'seller_name' =>  $seller_name,
            'designer_id' => 1,
            'designer_name' => 'diseñador',
            'priority_id' => 1,
            'type_id' => $request->type
        ]);
        // Guardar las imagenes y obtener las rutas
        $ruta_imagen_producto = $request['product']->store('upload-tickets_producto', 'public');
        $ruta_imagen_logo = $request['logo']->store('upload-tickets_logo', 'public');
        // Registrar la informacion del ticket



        $ticketInformation = TicketInformation::create([
            'ticket_id' => $ticket->id,
            'status_id' => 1,
            'customer' => $request->customer,
            'technique' => $request->technique,
            'description' => $request->description,
            'title' => $request->title,
            'logo' => $ruta_imagen_logo,
            'product' => $ruta_imagen_producto,
            'pantone' => $request->pantone,
        ]);


        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'reference_id' => $ticketInformation->id,
            'type' => 'info'
        ]);
        // Regresar a la vista de inicio
        return redirect()->action('HomeController@index');
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

        $ticketHistories = $ticket->historyTicket()->orderByDesc('created_at')->get();
        return view(
            'seller.tickets.show',
            compact('messages', 'ticketInformation', 'ticket', 'statuses','ticketHistories')
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
        $ticketInformation = ([
            'ticket_id' => $ticket->id,
            'status_id' => 1,
            'customer' => $request->customer,
            'technique' => $request->technique,
            'description' => $request->description,
            'title' => $request->title,
            'logo' => $ruta_imagen_logo,
            'product' => $ruta_imagen_producto,
            'pantone' => $request->pantone,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        TicketInformation::insert($ticketInformation);

        // Regresar a la vista de inicio
        return redirect()->action('HomeController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
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
}
