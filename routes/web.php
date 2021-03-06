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

//Route::get('/', function () {
//    return view('index');
//});

Route::resource('carros', 'CarroController');
Route::get('carrosfoto/{id}', 'CarroController@foto')
        ->name('carros.foto');
Route::post('carrosfotostore', 'CarroController@storefoto')
        ->name('carros.storefoto');
Route::get('carrospesq', 'CarroController@pesq')
        ->name('carros.pesq');
Route::post('carrosfiltro', 'CarroController@filtro')
        ->name('carros.filtro');

Route::get('carrosgraf', 'CarroController@graf')
        ->name('carros.graf');


Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('register', function() {
    return "<h1> Permissão Negada </h1>";
});

Route::resource('clientes', 'ClienteController');

// Rotas dos Web Services
Route::get('carrosws/{id?}', 'CarroController@ws');
Route::get('carrosxml/{id?}', 'CarroController@xml');

