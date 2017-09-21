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
Route::post('/video', 'Video\VideoController@index');
Route::get('/readvideo/{id}/{id1}', 'Video\VideoController@readvideo');
Route::get('/play/{id}', 'Video\VideoController@play');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
