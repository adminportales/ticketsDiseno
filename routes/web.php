<?php

use App\Events\MessageSendEvent;
use App\Events\OrderStatusChangeEvent;
use App\Http\Controllers\StatisfactionController;
use App\Http\Controllers\TeamDisenoController;
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
Route::get('/markNotification/{notification}', 'MessageController@markAsRead')->name('message.markAsRead');
Route::get('/markAllNotifications', 'MessageController@markAllAsRead')->name('message.markAllAsRead');

// Home de cada uno de los perfiles
Route::get('/home', 'HomeController@index')->middleware('user.active')->name('home');
Route::get('/home/inactive', 'HomeController@userActive')->name('user.active');

// Rutas del administrador
Route::resource('/users', 'UserController')->except('show');
Route::get('/viewHistory', 'AdminController@viewHistory')->name('viewChanges');
// Importar usuarios
Route::get('/users/import', 'UserController@sample')->name('user.import.create');
Route::post('/users/import', 'UserController@import')->name('user.import');
Route::get('/users/all', 'UserController@allUsers');


// Ruta de los equipos
Route::resource('/teams', 'TeamController');
Route::resource('/teamsdiseno', 'TeamDisenoController');
Route::post('/teamsdiseno/disable', 'TeamDisenoController@disable');
// Rutas del diseñador
route::get('/designer/ticketShow/{ticket}', 'DesignerController@show')->name('designer.show');
Route::get('/designer/home', 'DesignerController@index')->name('designer.inicio');
Route::get("/designer/list-wait", 'DesignerController@listWait')->name('designer.listWait');
Route::get("/designer/list-encuestas/{designer}", 'DesignerController@listEncuesta')->name('designer.listEncuesta');
Route::get('/designer/deleteFile/{delivery_id}', 'DesignerController@deleteFile')->name('tickets.deleteFile');
Route::post('/designer/return/ticket', 'DesignerController@returnticket')->name('return.ticket');


// Rutas del gerente de diseño
Route::get('/design_manager/all-tickets', 'DesignerManagerController@allTickets')->name('design_manager.all');
Route::get('/design_manager/mis-tickets', 'DesignerManagerController@verTickets')->name('design_manager.tickets');
Route::get('/design_manager/assign-ticket', 'DesignerManagerController@ticketAssign')->name('design_manager.assign');
Route::get('/design_manager/edit-asign/{user}', 'TicketAssigmentController@edit')->name('ticketAssigment.edit');
Route::put('/design_manager/edit-asign/{user}', 'TicketAssigmentController@update')->name('ticketAssigment.update');
Route::put('/design-manager/update-availability/{user}', 'ProfileController@updateStatus')->name('profile.updateStatus');
Route::put('/design-manager/update-assign/{ticket}', 'TicketAssigmentController@changeDesigner');

// Cambio de estado
Route::put('/design/update-status/{ticket}', 'StatusController@update');
Route::get('/ticketsViewAll', 'AdminController@viewTickets')->name('admin.verTickets');
Route::get('/encuestas', 'AdminController@viewEncuestas')->name('admin.encuestas');

// Gerente de Ventas
Route::get('/sales_manager/all-tickets', 'SalesManagerController@allTickets')->name('sales_manager.all');
Route::get('/sales_manager/tickets', 'TicketController@index')->name('sales_manager.index');
Route::get('/sales_manager/tickets/create', 'TicketController@create')->name('sales_manager.create');
Route::put('/sales-manager/update-priority/{ticket}', 'PriorityController@update');

// Rutas del vendedor
Route::resource('/tickets', 'TicketController');
Route::post('/tickets/items', 'TicketUploadController@uploadItems')->name('tickets.uploadItems');
Route::post('/tickets/deleteItem', 'TicketUploadController@deleteItem')->name('tickets.deleteItem');
Route::post('/tickets/upload-product', 'TicketUploadController@uploadProducts')->name('tickets.uploadProducts');
Route::post('/tickets/deleteProduct', 'TicketUploadController@deleteProduct')->name('tickets.deleteProduct');
Route::post('/tickets/upload-logo', 'TicketUploadController@uploadLogos')->name('tickets.uploadLogos');
Route::post('/tickets/deleteLogo', 'TicketUploadController@deleteLogo')->name('tickets.deleteLogo');
Route::post('/satisfaccion', [StatisfactionController::class, 'store'])->name('satisfaccion.store');

//Entregas de parte de diseño
Route::post('/tickets/delivery', 'TicketController@uploadDeliveries')->name('tickets.uploadDeliveries');
Route::post('/tickets/deleteDelivery', 'TicketController@deleteDelivery')->name('tickets.deleteDelivery');
Route::post('tickets/delivery/{ticket}', 'TicketDeliveryController@store')->name('ticket.delivery');

//Ruta para descargar archivos comprimidos
Route::get('/tickets/descargas/{ticket}', 'TicketController@descargarArchivos')->name('descarga.archivosTicket');

//Ruta de asistente
route::get('/asistente', 'AssistentController@index')->name('assitent');


//ruta para subir foto de perfil
Route::patch('/profile', 'ProfileController@update_profile')->name('user.profile.update');

// Vista previa del archivo
Route::get('/viewFile/{file}/{folder}', 'TicketController@viewFile')->name('tickets.viewFile');
