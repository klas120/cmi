<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
	]);

Route::get('tablero', 'TableroController@getMostrar');




/* 	RUTAS DE EJEMPLO PARA CMI   -----------------------------------------
 * ----------------------------------------------------------------------
 						INICIO
 * ----------------------------------------------------------------------
 */
resource('terceros','TerceroController');

Route::post('actualizar-tercero/{id}', [
	'as' => 'actualizar_tercero',
	'uses' => 'TerceroController@update'
	]);

Route::get('terceros', 'TerceroController@index');
Route::get('terceros/{id}/edit', 'TerceroController@edit');
Route::get('terceros/{id}/delete', 'TerceroController@destroy');

Route::get('terceros_mostrar', 'TerceroController@mostrar');

/* ---------------------------------------------------------------------
						FIN  
 * ---------------------------------------------------------------------
 * ---------------------------------------------------------------------
 */
