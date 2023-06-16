<?php

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
//crear las dos rutas del proyecto
Route::get('/stocknecesario','StockNecesarioController@list');
Route::get('/stocknecesario/{id}','StockNecesarioController@Search_ID');
Route::get('/stockperdido','StockPerdidoController@list');
//Ruta donde muestra el hitorial de venta de determinado producto
Route::get('/Registro/{id}','StockNecesarioController@HistorialRegistro');
//Ruta para ingregar comentario
Route::post('/IngresarComentario/{id}','StockGuardadoController@IngrearComentario');

//Ruta a la pagina de StockGuardado
Route::get('/stockarchivado','StockGuardadoController@list');

//Ruta de cambio de variable de la vista stockNecesario
Route::post('/TransferirA/{id}','StockNecesarioController@CambiarVariable');

//Ruta de cambio de variable de la vista stockguardado
Route::delete('/TransferirB/{id}','StockGuardadoController@BorrarVariable');

