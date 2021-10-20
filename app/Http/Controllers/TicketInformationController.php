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
}
