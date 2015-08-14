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

// Route::get('dummy', 'DummyController@index');

Route::group(['middleware' => ['auth']], function() {

	Route::get('pengajuan/destroy/{id}', 'GroupController@destroy');
	Route::get('pengajuan/mentor/{id}', 'GroupController@updateMentor');

	Route::get('berita', 'BeritaController@index');
	Route::get('file/{id}/{name}', 'BeritaController@file');

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
		Route::post('settings', 'SettingsController@store');
		Route::get('stats', 'SettingsController@stats');
		Route::get('stats/{semester}', 'SettingsController@stats');
		Route::get('table', 'SettingsController@table');
		Route::get('table/export', 'SettingsController@export');
		Route::get('table/export/{semester}', 'SettingsController@export');
		Route::get('table/grading/{id}', 'SettingsController@grading');
		Route::get('table/{semester}', 'SettingsController@table');
		Route::post('berita/edit', 'BeritaController@update');
		Route::post('berita/tambah', 'BeritaController@store');
	});
});

Route::controllers([
	'auth' => 'AuthController',
]);
