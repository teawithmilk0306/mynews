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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    //Laravel 12の課題2
    Route::get('profile/create', 'Admin\ProfileController@add');
    //Laravel 12の課題3
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('news/create', 'Admin\NewsController@create');
    //Laravel 13の課題3
    Route::post('profile/create', 'Admin\ProfileController@create');
    //Laravel 13の課題6
    Route::post('profile/edit', 'Admin\ProfileController@update');
    
});

//Route::get('admin/profile/create', 'Admin\ProfileController@add');

//Route::get('admin/profile/edit', 'Admin\ProfileController@edit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


