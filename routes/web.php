<?php

use App\Http\Controllers\DesignerController;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas de Inicio de Sesion
Auth::routes(['verify' => true]);

// Ruta de inicio de la aplicacion
Route::get('/', function () {
    return redirect('/home');
});

// Home de cada uno de los perfiles
Route::get('/home', 'HomeController@index')->middleware('user.active')->name('home');
Route::get('/home/inactive', 'HomeController@userActive')->name('user.active');

// Rutas del administrador
Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::resource('/users', 'UserController')->except('show');
});

// Rutas del diseñador
Route::prefix('designer')->middleware('role:designer|design_manager')->group(function () {
    route::get('/ticketShow/{ticket}', 'DesignerController@show')->name('designer.show');
    Route::get('/designer/home', 'DesignerController@index')->name('designer.inicio');

    Route::get('/design_manager/ver-tickets', 'DesignerManagerController@index')->name('design_manager.inicio');
    Route::get('/design_manager/mis-tickets', 'DesignerManagerController@verTickets')->name('design_manager.tickets');
    Route::get('/design_manager/assign-ticket', 'DesignerManagerController@ticketPropio')->name('design_manager.assign');
});

// Rutas del vendedor
Route::prefix('seller')->middleware('role:seller|sales_manager')->group(function () {
    Route::resource('/tickets', 'TicketController');
});
Route::post('/tickets/items', 'TicketController@uploadItems')->name('tickets.uploadItems');
Route::post('/tickets/deleteItem', 'TicketController@deleteItem')->name('tickets.deleteItem');
Route::post('/tickets/upload-product', 'TicketController@uploadProducts')->name('tickets.uploadProducts');
Route::post('/tickets/deleteProduct', 'TicketController@deleteProduct')->name('tickets.deleteProduct');
Route::post('/tickets/upload-logo', 'TicketController@uploadLogos')->name('tickets.uploadLogos');
Route::post('/tickets/deleteLogo', 'TicketController@deleteLogo')->name('tickets.deleteLogo');

//Ruta de mensajes
Route::post('/message', 'MessageController@store')->name('message.store');
route::post('/message/create', 'DesignerController@messageStore')->name('designer.store');

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
