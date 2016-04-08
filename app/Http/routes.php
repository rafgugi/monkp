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

Route::get('/', function() {
	return redirect('home');
});

// Route::get('dummy', 'DummyController@index');

Route::group(['middleware' => ['auth']], function() {

	Route::get('home', 'GroupController@index');
	Route::get('pengajuan/destroy/{id}', 'GroupController@destroy');
	Route::get('pengajuan/mentor/{id}', 'GroupController@updateMentor');

	Route::get('berita', 'PostController@index');
	Route::get('file/{id}/{name}', 'PostController@file');

	Route::get('json/groupgrade/{id}', 'GroupController@getGroupWithGrade');
	Route::post('pengajuan/nilai', 'GroupController@updateGrade');

	Route::group(['middleware' => ['student']], function() {
		Route::get('pengajuan', 'PengajuanController@create');
		Route::get('pengajuan/accept/{id}', 'PengajuanController@accept');
		Route::get('pengajuan/reject/{id}', 'PengajuanController@reject');
		Route::post('pengajuan', 'PengajuanController@store');
	});

	Route::group(['middleware' => ['admin']], function() {
		Route::get('berita/hapus/{id}', 'PostController@destroy');
		Route::post('berita/edit', 'PostController@update');
		Route::post('berita/tambah', 'PostController@store');

		Route::get('pengajuan/update/{id}', 'GroupController@update');

		Route::get('periode', 'AdminController@getPeriode');
		Route::post('periode', 'AdminController@postPeriode');

		Route::get('stats', 'AdminController@stats');
		Route::get('stats/{semester}', 'AdminController@stats');

		Route::get('table', 'AdminController@table');
		Route::get('table/export', 'AdminController@export');
		Route::get('table/export/{semester}', 'AdminController@export');
		Route::get('table/grading/{id}', 'AdminController@grading');
		Route::get('table/{semester}', 'AdminController@table');

		Route::get('users', 'UserController@create');
		Route::post('users/mahasiswa', 'UserController@student');
		Route::post('users/dosen', 'UserController@lecturer');
		Route::post('users/reset', 'UserController@reset');
	});

	Route::get('modal/perusahaan/{id}', 'AdminController@showCorporation');
});

Route::controllers([
	'auth' => 'AuthController',
]);
