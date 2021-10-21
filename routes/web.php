<?php

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

// Rutas del diseñador
route::get('/designer/ticketShow/{ticket}', 'DesignerController@show')->name('designer.show');
Route::get('/designer/home', 'DesignerController@index')->name('designer.inicio');

// Rutas del gerente de diseño
Route::get('/design_manager/ver-tickets', 'DesignerManagerController@index')->name('design_manager.inicio');
Route::get('/design_manager/mis-tickets', 'DesignerManagerController@verTickets')->name('design_manager.tickets');
Route::get('/design_manager/assign-ticket', 'DesignerManagerController@ticketPropio')->name('design_manager.assign');

// Gerente de Ventas
Route::get('/sales_manager/all-tickets', 'SalesManagerController@allTickets')->name('sales_manager.all');
Route::get('/sales_manager/tickets', 'TicketController@index')->name('sales_manager.index');
Route::get('/sales_manager/tickets/create', 'TicketController@create')->name('sales_manager.create');

// Rutas del vendedor
Route::resource('/tickets', 'TicketController');
Route::post('/tickets/items', 'TicketController@uploadItems')->name('tickets.uploadItems');
Route::post('/tickets/deleteItem', 'TicketController@deleteItem')->name('tickets.deleteItem');
Route::post('/tickets/upload-product', 'TicketController@uploadProducts')->name('tickets.uploadProducts');
Route::post('/tickets/deleteProduct', 'TicketController@deleteProduct')->name('tickets.deleteProduct');
Route::post('/tickets/upload-logo', 'TicketController@uploadLogos')->name('tickets.uploadLogos');
Route::post('/tickets/deleteLogo', 'TicketController@deleteLogo')->name('tickets.deleteLogo');
