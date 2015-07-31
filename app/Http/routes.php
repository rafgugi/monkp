<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested. Note:
| register all middleware filter here as well.
|
*/

Route::get('home', 'GroupController@home');
Route::get('/', function() {
	return redirect('home');
});

Route::group(['middleware' => ['auth']], function() {

	Route::get('pengajuan/destroy/{id}', 'GroupController@destroy');
	Route::get('pengajuan/mentor/{id}', 'GroupController@updateMentor');

	Route::get('berita', 'BeritaController@index');
	Route::get('file/{id}', 'BeritaController@file');

	Route::group(['middleware' => ['student']], function() {
		Route::get('pengajuan', 'PengajuanController@create');
		Route::get('pengajuan/accept/{id}', 'PengajuanController@accept');
		Route::get('pengajuan/reject/{id}', 'PengajuanController@reject');
		Route::post('pengajuan', 'PengajuanController@store');
	});

	Route::group(['middleware' => ['admin']], function() {
		Route::get('berita/hapus/{id}', 'BeritaController@destroy');
		Route::get('pengajuan/update/{id}', 'GroupController@update');
		Route::get('settings', 'SettingsController@index');
		Route::get('stats', 'GroupController@stats');
		Route::get('table', 'GroupController@table');
		Route::get('table/grading/{id}', 'GroupController@grading');
		Route::get('table/export', 'GroupController@export');
		Route::post('berita/tambah', 'BeritaController@store');
	});
});

Route::controllers([
	'auth' => 'AuthController',
]);
