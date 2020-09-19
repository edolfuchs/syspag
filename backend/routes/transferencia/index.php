<?php
use Illuminate\Support\Facades\Route;

Route::post('', 'UsuarioTransferenciaController@efetuarTransferencia');
Route::get('', 'UsuarioTransferenciaController@listar');