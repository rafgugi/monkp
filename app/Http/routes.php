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

Route::get('/', function() {
	return redirect('home');
});
Route::get('tabel', function() {
	return view('inside.tabel');
});

Route::get('home', 'HomeController@index');

Route::group(['middleware' => ['auth']], function() {
	Route::get('pengajuan', 'PengajuanController@create');
	Route::post('pengajuan', 'PengajuanController@store');
	Route::get('pengajuan/accept/{id}', 'PengajuanController@accept');
	Route::get('pengajuan/reject/{id}', 'PengajuanController@reject');

	Route::get('berita', 'BeritaController@index');
	Route::post('berita/tambah', 'BeritaController@store');
});

Route::controllers([
	'auth' => 'AuthController',
]);
