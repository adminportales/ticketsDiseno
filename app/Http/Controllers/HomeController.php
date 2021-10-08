<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->hasRole('seller')) {
           return redirect()->action('TicketController@index');
        }

        if (auth()->user()->hasRole('designer')) {
            return view('diseñador.inicio_diseno');
        }

        if (auth()->user()->hasRole('admin')) {
            return view('administrador.inicio');
        }

        if (auth()->user()->hasRole('saler_manager')) {
            return view('gerente_ventas.inicio_gerenteventas');
        }

        if (auth()->user()->hasRole('saler_design')) {
            return view('gerentediseño.inicio_gerente_diseño');
        }
        return view('home');
    }
}
