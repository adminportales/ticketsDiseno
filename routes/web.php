<?php

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Rutas de Inicio de Sesion
Auth::routes(['verify' => true]);

// Ruta de inicio de la aplicacion
Route::get('/', function () {
    return redirect('/home');
});

// Home de cada uno de los perfiles
Route::get('/home', 'HomeController@index')->name('home');

// Rutas del administrador
Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::resource('/users', 'UserController')->except('show');
});

// Rutas del diseñador
Route::prefix('designer')->middleware('role:designer')->group(function () {
    Route::get('/designer', 'DesignerController@index')->name('designer.inicio');
});

// Rutas del vendedor
Route::prefix('seller')->middleware('role:seller')->group(function () {
    Route::resource('/tickets', 'TicketController');
});
Route::post('/tickets/items', 'TicketController@uploadItems')->name('tickets.uploadItems');
Route::post('/tickets/deleteItem', 'TicketController@deleteItem')->name('tickets.deleteItem');

//Ruta de mensajes
Route::post('/message', 'MessageController@store')->name('message.store');

/* // Rutas del gerente de diseño
Route::prefix('designer_manager')->middleware('role:designer')->group(function () {
    Route::get('/designer', 'DesignerController@index')->name('designer.inicio');
});

// Rutas del gerente de ventas
Route::prefix('seller_manager')->middleware('role:seller')->group(function () {
    Route::resource('/tickets', 'TicketController');
});
 */








Route::get('reporte_tickets', function () {
    return view('administrador.reporte_tickets');
})->name('reporte_tickets');

Route::get('inicio_vendedor', function () {
    return view('vendedor.inicio');
})->name('inicio_vendedor');

Route::get('crear_ticket', function () {
    return view('vendedor.crear_ticket');
})->name('crear_ticket');

Route::get('consultar_ticket', function () {
    return view('vendedor.consultar_ticket');
})->name('consultar_ticket');

Route::get('modificar_ticket', function () {
    return view('vendedor.modificar_ticket');
})->name('modificar_ticket');

Route::get('atender_ticket', function () {
    return view('vendedor.atender_ticket');
})->name('atender_ticket');

Route::get('inicio_diseno', function () {
    return view('diseñador.inicio_diseno');
})->name('inicio_diseno');

Route::get('consultar_ticket_diseño', function () {
    return view('diseñador.consultar_ticket_diseño');
})->name('consultar_ticket_diseño');

Route::get('atender_ticket_diseño', function () {
    return view('diseñador.atender_ticket_diseño');
})->name('atender_ticket_diseño');

Route::get('inicio_gerente_diseño', function () {
    return view('gerentediseño.inicio_gerente_diseno');
})->name('inicio_gerente_diseño');

Route::get('reasignar_tickets', function () {
    return view('gerentediseño.reasignar_tickets');
})->name('reasignar_tickets');

Route::get('consultar_ticketgerente', function () {
    return view('gerentediseño.consultar_ticketgerente');
})->name('consultar_ticketgerente');

Route::get('inicio_gerenteventas', function () {
    return view('gerente_ventas.inicio_gerenteventas');
})->name('inicio_gerenteventas');

Route::get('consultar_ticketventas', function () {
    return view('gerente_ventas.consultar_ticketventas');
})->name('consultar_ticketventas');

Route::get('asignar_prioridades', function () {
    return view('gerente_ventas.asignar_prioridades');
})->name('asignar_prioridades');

Route::get('crear_ticketventas', function () {
    return view('gerente_ventas.crear_ticketventas');
})->name('crear_ticketventas');

Route::get('modificar_ticketventas', function () {
    return view('gerente_ventas.modificar_ticketventas');
})->name('modificar_ticketventas');

Route::get('atender_ticketventas', function () {
    return view('gerente_ventas.atender_ticketventas');
})->name('atender_ticketventas');
