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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('vps/create', 'VpsController@create');
Route::post('vps/store', 'VpsController@store');
Route::get('vps/{id}/edit', 'VpsController@edit');
Route::put('vps/{id}/update', 'VpsController@update');
Route::delete('vps/{id}/destroy', 'VpsController@destroy');
Route::get('websites/create', 'WebsitesController@create');
Route::post('websites/store', 'WebsitesController@store');
Route::get('user/change-password', 'UsersController@changePassword')->name('change-password');
Route::put('websites/store', 'UsersController@updatePassword');