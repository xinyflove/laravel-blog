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

/*测试路由开始*/
Route::namespace('Admin')->group(function() {
// App\Http\Controllers\Admin\AdminController
    Route::get('/admin', 'AdminController@index');
});
Route::resource('post', 'PostController');
/*测试路由结束*/

Route::get('/blog', 'BlogController@index')->name('blog.home');
Route::get('/blog/{slug}', 'BlogController@showPost')->name('blog.detail');
// 后台路由
Route::get('/admin', function () {
    return redirect('/admin/post');
});
Route::middleware('auth')->namespace('Admin')->group(function () {
    Route::resource('admin/post', 'PostController', ['except' => 'show']);
    Route::resource('admin/tag', 'TagController', ['except' => 'show']);
    Route::get('admin/upload', 'UploadController@index');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');
});
// 登录退出
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('contact', 'ContactController@showForm');
Route::post('contact', 'ContactController@sendContactInfo');