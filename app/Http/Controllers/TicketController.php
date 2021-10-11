<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketInformation;
use App\Type;
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
        $tickets = Ticket::all();
        return view('seller.tickets.index', compact('tickets'));
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

        $datosTicket = request()->except('_token');



        //return response()->json($datosTicket);
        // Validar los datos
        request()->validate([
            'category' => 'required',
            'customer' => ['required', 'string', 'max:255'],
            'technique' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'logo' => 'required|image',
            'product' => 'required|image',
            'pantone' => 'required'

        ]);
        $seller_id = auth()->user()->id;
        $seller_name = auth()->user()->name . ' ' . auth()->user()->lastname;

        // Registrar el ticket
        $ticket = Ticket::create([
            'seller_id' => $seller_id,
            'seller_name' =>  $seller_name,
            'designer_id' => 1,
            'designer_name' => 'diseñador',
            'priority_id' => 1,
            'type_id' => 1

        ]);

        // Registrar la informacion del ticket
        $ticketInformation = ([
            'ticket_id' => $ticket->id,
            'status_id' => 1,
            'customer' => $request->customer,
            'technique' => $request->technique,
            'description' => $request->description,
            'title' => $request->title,
            'logo' => $request->logo,
            'product' => $request->product,
            'pantone' => $request->pantone

        ]);
        TicketInformation::insert($ticketInformation);



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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
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
        //
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
}
