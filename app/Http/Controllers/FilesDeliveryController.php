<?php

namespace App\Http\Controllers;

use App\FilesDelivery;
use Illuminate\Http\Request;

class FilesDeliveryController extends Controller
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
     * @param  \App\FilesDelivery  $filesDelivery
     * @return \Illuminate\Http\Response
     */
    public function show(FilesDelivery $filesDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FilesDelivery  $filesDelivery
     * @return \Illuminate\Http\Response
     */
    public function edit(FilesDelivery $filesDelivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FilesDelivery  $filesDelivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FilesDelivery $filesDelivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FilesDelivery  $filesDelivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilesDelivery $filesDelivery)
    {
        //
    }
}
