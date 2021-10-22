<?php

namespace App\Http\Controllers;

use App\TicketAssigment;
use App\Type;
use App\User;
use Illuminate\Http\Request;

class TicketAssigmentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function show(TicketAssigment $ticketAssigment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $types = Type::all();

        return view('design_manager.ticketAssigment.edit', compact('types', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketAssigment  $ticketAssigment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketAssigment $ticketAssigment)
    {
        //
    }
}
