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
//Ruta a la lista de usuarios
Route::get('/', 'Controller@index');

//Ruta a la lista de ordenes de un cliente.
Route::get('/{id}/show', 'clientsController@show');

//Ruta para crear ordenes.
Route::get('/{id}/create', 'ordersController@create');

//Ruta para operaciones REST/CRUD de ordenes.
Route::resource('orders', 'ordersController');

//Ruta para imprimir el PDF
Route::get('/imprimir/{id}', 'imprimirController@imprimir')->name('imprimir');

