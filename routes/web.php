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

Route::get('/', 'NewsController@index');
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    //Laravel 12の課題2
    Route::get('profile/create', 'Admin\ProfileController@add');
    //Laravel 12の課題3
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('news/create', 'Admin\NewsController@create');
    //Laravel 13の課題3
    Route::get('news', 'Admin\NewsController@index');
    //一覧画面へのRoutingを設定
    Route::post('profile/create', 'Admin\ProfileController@create');
    //Laravel 13の課題6
    Route::post('profile/edit', 'Admin\ProfileController@update');
    //edit Actionは編集画面を処理する部分
    Route::get('news/edit', 'Admin\NewsController@edit');
    //update Actionは編集画面から送信されたフォームデータを処理する部分
    Route::post('news/edit', 'Admin\NewsController@update');
    //削除機能は画面を持たず、id で指定されたModelをすぐに削除
    Route::get('news/delete', 'Admin\NewsController@delete');
    Route::get('profile/delete', 'Admin\ProfileController@delete');
    Route::get('profile', 'Admin\ProfileController@index');
    
   
});
//Route::get('admin/profile/create', 'Admin\ProfileController@add');
//Route::get('admin/profile/edit', 'Admin\ProfileController@edit');

//Laravel 19の課題２
Route::get('profile', 'ProfileController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

