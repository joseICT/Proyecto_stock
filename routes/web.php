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
//Ruta pagina de inicio de Stock Necesario
Route::get('/stocknecesario','StockNecesarioController@list');

//ruta que ya no es necesaria
Route::get('/stockperdido','StockPerdidoController@list');
//Ruta donde muestra el hitorial de venta de determinado producto
Route::get('/Registro/{id}','StockNecesarioController@HistorialRegistro');

//Ruta para ingregar comentario(no terminado)
Route::post('/IngresarComentario/{id}','StockGuardadoController@EscribirComentario');

//Ruta a la pagina de inicio de Stock Guardado
Route::get('/stockguardado','StockGuardadoController@list');

//Ruta para enviar producto a stock guardado desde stock necesario
Route::post('/TransferirA/{id}','StockNecesarioController@CambiarVariable');

//Ruta para enviar producto a stock necesario desde stock guardado
Route::delete('/TransferirB/{id}','StockGuardadoController@BorrarVariable');

//Ruta de crear requerimiento al presionar el boton
Route::post('/GenerarOrden/{id}','StockNecesarioController@RealizarRequerimiento');

//Ruta para interaccion de las 2 tablas en el modal historial
Route::post('/ClasificarVenta','StockGuardadoController@CambiarVentaMes');

//Ruta para despelgar datos de la segunda tabla de historial de ventas
Route::get('/RegistroB/{id}','StockNecesarioController@HistorialRegistro2');

//ruta para eliminar todo contenido de la segunda tabla
Route::delete('eliminartabla/{id}','StockNecesarioController@Borrartabla');
