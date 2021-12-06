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

Route::get('/', function () {
    return view('welcome');
});
// 登録
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register.get');
Route::post('/register', 'Auth\RegisterController@register')->name('register.post');
// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('list/','ProjectController@index')->name('project.index');
    Route::post('list/updateproject/','ProjectController@updateproject')->name('project.updateproject');
    Route::post('list/documentsupload/','ProjectController@documentsupload')->name('project.documentsupload');
    Route::post('list/finaldocumentsupload/','ProjectController@finaldocumentsupload')->name('project.finaldocumentsupload');
    Route::post('list/fdelete/','ProjectController@fdelete')->name('project.fdelete');


    Route::post('claims/create/','ClaimController@create')->name('claims.create');
    Route::post('claims/store/','ClaimController@store')->name('claims.store');
    Route::post('claims/fdelete/','ClaimController@fdelete')->name('claims.fdelete');
    
    Route::get('user/', 'UserController@index')->name('User.index'); 
    Route::post('user/update', 'UserController@update')->name('User.update'); 
    
    Route::post('customer/create', 'CustomerController@create')->name('Customer.cretate');
    Route::post('customer/edit', 'CustomerController@edit')->name('Customer.edit'); 
    Route::post('customer/store', 'CustomerController@store')->name('Customer.store'); 
    Route::post('mail', 'MailController@display')->name('Mail.display');

    Route::get('internal/', 'InternalController@index')->name('internal.index');
    Route::post('otherinternal/', 'InternalController@other_internal')->name('otherinternal.index');
    Route::post('internal/upload', 'InternalController@upload')->name('internal.upload');
    


    Route::get('files/', 'Genre_fileController@index')->name('genre_file.index');
    Route::post('files/', 'Genre_fileController@index')->name('genre_file.putindex');
    Route::get('files/create/{id}', 'Genre_fileController@create')->name('genre_file.create');
    Route::post('files/store', 'Genre_fileController@store')->name('genre_file.store');
    Route::post('files/store_destroy', 'Genre_fileController@store_destroy')->name('Genre_file.store_destroy');
    
    Route::post('departments/file', 'Department_fileController@index')->name('genre_file.department');
});