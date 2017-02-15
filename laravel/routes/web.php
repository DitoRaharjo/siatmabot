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
/* ----------- End of Front End Routes -------------  */
