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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('empleado','EmpleadoController@index')
->name('empleado.index')
->middleware('auth');
Route::post('empleado/envio','EmpleadoController@envio')
->name('empleado.envio')
->middleware('auth');
Route::post('empleado/registro','EmpleadoController@registro')
->name('empleado.registro')
->middleware('auth');