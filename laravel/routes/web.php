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

Route::get('/', function () {
    return view('welcome');
});

/* ---------------- Bot Updates Routes ---------------- */
Route::post('updates', 'BotController@updates')->name('bot.updates');
/* ------------ End of Bot Updates Routes ------------- */

/* ---------------- FrontEnd Routes -----------------  */
// Login - Logout
Route::get('login', 'UserController@login')->name('user.login');
Route::post('auth/login', 'UserController@doLogin')->name('user.auth.login');
Route::get('logout', 'UserController@doLogout')->name('user.logout');

//Register
Route::get('register', 'UserController@register')->name('user.register');
Route::post('register', 'UserController@doRegister')->name('user.do.register');

//Dashboard
Route::group(['middleware'=>'checkUser', 'auth'], function() {
  Route::get('dashboard-admin', 'UserController@dashboardAdmin')->name('dashboard.admin');
  Route::get('dashboard-mahasiswa', 'UserController@dashboardMahasiswa')->name('dashboard.mahasiswa');
});

//Fakultas
Route::group(['middleware'=>'checkUser', 'auth'], function() {
  Route::get('fakultas-index', 'FakultasController@index')->name('fakultas.index');
  Route::get('fakultas-store/{input}', 'FakultasController@store')->name('fakultas.store');
  Route::get('fakultas-update/{id}/{input}', 'FakultasController@update')->name('fakultas.update');
  Route::get('fakultas-delete/{id}', 'FakultasController@destroy')->name('fakultas.destroy');

  Route::get('fakultasTerhapus-restore/{id}', 'FakultasController@terhapusRestore')->name('fakultasTerhapus.restore');
  Route::get('fakultasTerhapus-destroy/{id}', 'FakultasController@terhapusDestroy')->name('fakultasTerhapus.destroy');
});

//Program Studi - Prodi
Route::group(['middleware'=>'checkUser', 'auth'], function() {
  Route::get('prodi-index', 'ProdiController@index')->name('prodi.index');
  Route::get('prodi-create', 'ProdiController@create')->name('prodi.create');
  Route::post('prodi-store', 'ProdiController@store')->name('prodi.store');
  Route::get('prodi-edit/{id}', 'ProdiController@edit')->name('prodi.edit');
  Route::patch('prodi-update/{id}', 'ProdiController@update')->name('prodi.update');
  Route::get('prodi-delete/{id}', 'ProdiController@destroy')->name('prodi.destroy');

  Route::get('prodiTerhapus-restore/{id}', 'ProdiController@terhapusRestore')->name('prodiTerhapus.restore');
  Route::get('prodiTerhapus-destroy/{id}', 'ProdiController@terhapusDestroy')->name('prodiTerhapus.destroy');
});

//Sesi
Route::group(['middleware'=>'checkUser', 'auth'], function() {
  Route::get('sesi-index', 'SesiController@index')->name('sesi.index');
  Route::get('sesi-create', 'SesiController@create')->name('sesi.create');
  Route::post('sesi-store', 'SesiController@store')->name('sesi.store');
  Route::get('sesi-edit/{id}', 'SesiController@edit')->name('sesi.edit');
  Route::patch('sesi-update/{id}', 'SesiController@update')->name('sesi.update');
  Route::get('sesi-delete/{id}', 'SesiController@destroy')->name('sesi.destroy');

  Route::get('sesiTerhapus-restore/{id}', 'SesiController@terhapusRestore')->name('sesiTerhapus.restore');
  Route::get('sesiTerhapus-destroy/{id}', 'SesiController@terhapusDestroy')->name('sesiTerhapus.destroy');
});
/* ----------- End of Front End Routes -------------  */
