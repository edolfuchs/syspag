<?php
use Illuminate\Support\Facades\Route;

Route::get('', 'UsuarioExtratoController@listar');
Route::post('', 'UsuarioExtratoController@cadastrarExtrato');