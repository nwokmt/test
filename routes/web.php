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
Route::get('/', 'TopController@index')->name('top');
Route::group(['prefix' => 'admin'], function() {
    Route::get('profile', 'Admin\ProfileController@front')->name('front')->middleware('auth');
    Route::get('profile/edit', 'Admin\ProfileController@add')->name('profile')->middleware('auth');
    Route::post('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
    Route::get('item', 'Admin\ItemController@list')->name('item')->middleware('auth');
    Route::get('item/detail/{id}', ['as' => 'detail', 'uses' => 'Admin\ItemController@detail'])->where(['id'=>'[0-9]+'])->middleware('auth');
    Route::get('item/add', ['as' => 'add', 'uses' => 'Admin\ItemController@add'])->middleware('auth');
    Route::get('item/edit/{id}', ['as' => 'edit', 'uses' => 'Admin\ItemController@edit'])->where(['id'=>'[0-9]+'])->middleware('auth');
    Route::post('item/save', ['as' => 'save', 'uses' => 'Admin\ItemController@save'])->middleware('auth');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

