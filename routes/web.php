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
Route::get('/web-sender/getMembers', 'WebSenderController@getMembers');
Route::get('/web-sender/saveChatLog', 'WebSenderController@saveChatLog');
Route::get('/web-sender/login', 'WebSenderController@login');
Route::get('/web-sender/chatLogIndex', 'WebSenderController@chatLogIndex');//聊天记录
Route::get('/web-sender/chatLogDetail', 'WebSenderController@chatLogDetail');//聊天记录数据