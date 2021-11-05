<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para los compradores
Route::get('/compradores', 'App\Http\Controllers\CompradorController@index'); 
Route::post('/compradores/save', 'App\Http\Controllers\CompradorController@store');
Route::get('/compradores/edit/{id}', 'App\Http\Controllers\CompradorController@edit'); 
Route::put('/compradores/update/{id}', 'App\Http\Controllers\CompradorController@update'); 
Route::delete('/compradores/delete/{id}', 'App\Http\Controllers\CompradorController@destroy'); 

// Rutas para la gestión de Boletas
Route::get('/boletas', 'App\Http\Controllers\BoletaController@index'); 
Route::post('/boletas/save', 'App\Http\Controllers\BoletaController@store');
Route::get('/boletas/edit/{id}', 'App\Http\Controllers\BoletaController@edit'); 
Route::put('/boletas/update/{id}', 'App\Http\Controllers\BoletaController@update'); 
Route::delete('/boletas/delete/{id}', 'App\Http\Controllers\BoletaController@destroy'); 

// Rutas para la gestión de Reservas
Route::get('/reservas', 'App\Http\Controllers\ReservaController@index'); 
Route::get('/reservas/datos', 'App\Http\Controllers\ReservaController@listaCompradoresYBoletas'); 
Route::post('/reservas/save', 'App\Http\Controllers\ReservaController@store');
// Route::put('/boletas/edit/{id}', 'App\Http\Controllers\ReservaController@update'); 
Route::delete('/reservas/delete/{id}', 'App\Http\Controllers\ReservaController@destroy'); 