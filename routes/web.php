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

Route::get('/web-sender', 'WebSenderController@index')->name('msg.sender.home');
Route::get('/web-sender/getList', 'WebSenderController@getList');
Route::get('/web-sender/login', 'WebSenderController@login');