<?php

namespace App\Http\Controllers;

use App\TicketInformation;
use Illuminate\Http\Request;

class TicketInformationController extends Controller
{

    public function __construct() {
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
     * @param  \App\TicketInformation  $ticketInformation
     * @return \Illuminate\Http\Response
     */
    public function show(TicketInformation $ticketInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TicketInformation  $ticketInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketInformation $ticketInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TicketInformation  $ticketInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketInformation $ticketInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TicketInformation  $ticketInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketInformation $ticketInformation)
    {
        //
    }
}
