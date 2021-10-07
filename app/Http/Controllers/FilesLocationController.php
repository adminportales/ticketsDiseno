<?php

namespace App\Http\Controllers;

use App\FilesLocation;
use Illuminate\Http\Request;

class FilesLocationController extends Controller
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
     * @param  \App\FilesLocation  $filesLocation
     * @return \Illuminate\Http\Response
     */
    public function show(FilesLocation $filesLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FilesLocation  $filesLocation
     * @return \Illuminate\Http\Response
     */
    public function edit(FilesLocation $filesLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FilesLocation  $filesLocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FilesLocation $filesLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FilesLocation  $filesLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilesLocation $filesLocation)
    {
        //
    }
}
