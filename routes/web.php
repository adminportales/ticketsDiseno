<?php

use App\Events\MessageSendEvent;
use App\Events\OrderStatusChangeEvent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas de Inicio de Sesion
Auth::routes(['verify' => true]);

// Rutas globales
Route::get('/', function () {
    return redirect('/home');
});

Route::post('/message', 'MessageController@store')->name('message.store');

// Home de cada uno de los perfiles
Route::get('/home', 'HomeController@index')->middleware('user.active')->name('home');
Route::get('/home/inactive', 'HomeController@userActive')->name('user.active');

// Rutas del administrador
Route::resource('/users', 'UserController')->except('show');
// Importar usuarios
Route::get('/users/import', 'UserController@sample')->name('user.import.create');
Route::post('/users/import', 'UserController@import')->name('user.import');
// Rutas del diseñador
route::get('/designer/ticketShow/{ticket}', 'DesignerController@show')->name('designer.show');
Route::get('/designer/home', 'DesignerController@index')->name('designer.inicio');

// Rutas del gerente de diseño
Route::get('/design_manager/all-tickets', 'DesignerManagerController@allTickets')->name('design_manager.all');
Route::get('/design_manager/mis-tickets', 'DesignerManagerController@verTickets')->name('design_manager.tickets');
Route::get('/design_manager/assign-ticket', 'DesignerManagerController@ticketAssign')->name('design_manager.assign');
Route::get('/design_manager/edit-asign/{user}', 'TicketAssigmentController@edit')->name('ticketAssigment.edit');
Route::put('/design_manager/edit-asign/{user}', 'TicketAssigmentController@update')->name('ticketAssigment.update');
Route::put('/design-manager/update-availability/{user}', 'ProfileController@updateStatus')->name('profile.updateStatus');
// TODO: Crear una nueva ruta para el cambio de prioridad
Route::put('/design-manager/update-assign/{ticket}', 'TicketAssigmentController@changeDesigner');

Route::put('/design/update-status/{ticket}', 'StatusController@update');

// Gerente de Ventas
Route::get('/sales_manager/all-tickets', 'SalesManagerController@allTickets')->name('sales_manager.all');
Route::get('/sales_manager/tickets', 'TicketController@index')->name('sales_manager.index');
Route::get('/sales_manager/tickets/create', 'TicketController@create')->name('sales_manager.create');
Route::put('/sales-manager/update-priority/{ticket}', 'PriorityController@update');

// Rutas del vendedor
Route::resource('/tickets', 'TicketController');
Route::post('/tickets/items', 'TicketController@uploadItems')->name('tickets.uploadItems');
Route::post('/tickets/deleteItem', 'TicketController@deleteItem')->name('tickets.deleteItem');
Route::post('/tickets/upload-product', 'TicketController@uploadProducts')->name('tickets.uploadProducts');
Route::post('/tickets/deleteProduct', 'TicketController@deleteProduct')->name('tickets.deleteProduct');
Route::post('/tickets/upload-logo', 'TicketController@uploadLogos')->name('tickets.uploadLogos');
Route::post('/tickets/deleteLogo', 'TicketController@deleteLogo')->name('tickets.deleteLogo');
Route::post('/tickets/delivery', 'TicketController@uploadDeliveries')->name('tickets.uploadDeliveries');
Route::post('/tickets/deleteDelivery', 'TicketController@deleteDelivery')->name('tickets.deleteDelivery');
Route::post('tickets/delivery/{ticket}', 'TicketDeliveryCOntroller@store')->name('ticket.delivery');

//Ruta para descargar archivos comprimidos
Route::get('/tickets/descargas/{ticket}', 'TicketController@descargarArchivos')->name('descarga.archivosTicket');
