<?php
use Illuminate\Support\Facades\Route;

Route::get('', 'UsuarioController@listar');
Route::get('me', 'AuthController@me');
Route::get('saldo', 'UsuarioController@listarSaldoPorUsuario');