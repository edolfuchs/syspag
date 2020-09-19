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

Route::post('login', 'AuthController@login');
Route::post('cadastrar', 'UsuarioController@cadastrarUsuario');

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('me', 'AuthController@me');

    //USUARIO
    Route::group(['prefix' => 'usuario'], function () {
        include 'usuario/index.php';
    });

    //TRANSFERENCIA
    Route::group(['prefix' => 'transferencia'], function () {
        include 'transferencia/index.php';
    });

    //SALDO
    Route::group(['prefix' => 'extrato'], function () {
        include 'extrato/index.php';
    });
});
