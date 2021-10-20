<?php

namespace App\Http\Controllers;

use App\TicketDelivery;
use Illuminate\Http\Request;

class TicketDeliveryController extends Controller
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
}
