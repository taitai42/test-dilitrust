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

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/toggleAccess/{id}/{user_id}/{can_see}', 'HomeController@toggleAccess')->name('toggleAccess');
Route::get('/delete/{id}', 'HomeController@delete')->name('delete');
Route::get('/{id}', 'HomeController@view')->name('view');
Route::post('/upload', 'HomeController@upload')->name('upload');
