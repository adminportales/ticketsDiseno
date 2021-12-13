<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TicketSeeder;

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
        // Revisar el rol de el usuario y si no tiene asignado ninguno, enviarlo al hobe
        switch (auth()->user()->whatRoles[0]->name) {
            case 'admin':
                return AdminController::dashboard();
                break;
            case 'seller':
                return SellerController::dashboard();
                break;
            case 'designer':
                return DesignerController::dashboard();
                break;
            case 'sales_manager':
                return SalesManagerController::dashboard();
                break;
            case 'design_manager':
                return DesignerManagerController::dashboard();
                break;
            case 'sales_assistant':
                return AssistentController::dashboard();
                break;
            default:
                return SellerController::dashboard();
                break;
        }
    }

    // Retorna la vista inactivo en caso de que el usuario haya sido eliminado
    public function userActive()
    {
        return view('inactive');
    }
}
