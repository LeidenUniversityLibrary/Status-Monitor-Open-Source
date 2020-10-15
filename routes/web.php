<?php

use Illuminate\Support\Facades\Route;

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

// SECTION Public routes
Route::get('/', 'HomepageController@index')->name('homepage');

// SECTION Admin routes
Route::get('/monitors', 'StatusController@index')->name('admin_monitors')->middleware('auth');
Route::post('/monitors', 'StatusController@store')->middleware('auth');
Route::get('/monitor/{id}', 'StatusController@edit')->name('edit_monitor')->middleware('auth');
Route::post('/monitor/{id}', 'StatusController@update')->name('update_monitor')->middleware('auth');
Route::delete('/monitor/{id}', 'StatusController@destroy')->name('delete_monitor')->middleware('auth');

// SECTION Manual checks routes
Route::get('/admin/check-uptime', 'StatusController@check_status_manually')->name('check_status_manually')->middleware('auth');
Route::get('/admin/check-ssl', 'StatusController@check_SSL_certificates')->name('check_SSL_certificates')->middleware('auth');

// SECTION Alerts routes
Route::get('/alerts', 'AlertController@index')->name('admin_alerts')->middleware('auth');
Route::post('/alerts', 'AlertController@store')->middleware('auth');
Route::get('/alert/{id}', 'AlertController@edit')->name('edit_alert')->middleware('auth');
Route::post('/alert/{id}', 'AlertController@update')->name('update_alert')->middleware('auth');
Route::delete('/alert/{id}', 'AlertController@destroy')->name('delete_alert')->middleware('auth');

// SECTION Authentication routes
Auth::routes(['register' => false, 'reset'=> false, 'verify'=>false]);