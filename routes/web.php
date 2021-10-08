<?php

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
Auth::routes(['verify' => true]);


Route::resource('/users','UserController');
Route::resource('/tickets','TicketController');

Route::get('/', function () {
    return redirect('/home');
});

Route::get('inicio', function () {
    return view('administrador.inicio');
})->name('inicio');

Route::get('ver_usuario', function () {
    return view('administrador.ver_usuario');
})->name('ver_usuario');

Route::get('crear_usuario', function () {
    return view('administrador.crear_usuario');
})->name('crear_usuario');

Route::get('modificar_usuario', function () {
    return view('administrador.modificar_usuario');
})->name('modificar_usuario');

Route::get('asignar_permisos', function () {
    return view('administrador.asignar_permisos');
})->name('asignar_permisos');

Route::get('editar_usuario', function () {
    return view('administrador.editar_usuario');
})->name('editar_usuario');

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

Route::get('/home', 'HomeController@index')->name('home');
