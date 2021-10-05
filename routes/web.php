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

Route::get('/', function () {
    return view('welcome');
});

Route::get('inicio', function () {
    return view('administrador.pagina_inicio');
})->name('Inicio');

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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
