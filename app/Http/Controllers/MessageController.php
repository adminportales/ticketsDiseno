<?php

namespace App\Http\Controllers;

use App\Message;
use App\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Obtener los datos del formulario de mensajes
        request()->validate(
            [

                'message' => ['required', 'string'],
                'ticket_id' => ['required']

                ]
            );


        // Obtener el id del ticket, hay traerlo del formulario
        $ticket = Ticket::find($request->ticket_id);

        // Obtener el id y nombre del vendedor y diseñador asignados al ticket
        $seller_id = auth()->user()->id;
        $seller_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        $designer_id = auth()->user()->id;
        $designer_name = auth()->user()->name . ' ' . auth()->user()->lastname;
        // Guardar el mensaje con los sigioetes datos

        $message = Message::create([
            "seller_id" => $seller_id,
            "seller_name" => $seller_name,
            "designer_id" => $designer_id,
            "designer_name" => $designer_name,
            "message" =>$request->message,
            "ticket_id" => $ticket->id

        ]);



        // Regresar a la misma vista AtenderTicket (ticket.show)
    return redirect()->action('TicketController@show', ['ticket'=>$ticket->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
