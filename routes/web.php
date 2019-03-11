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

//�g�b�v�y�[�W
Route::get('/', 'TopController@index')->name('top');
//���i�ڍ�
Route::get('/detail/{id}', 'OrderController@detail')->where(['id'=>'[0-9]+']);
//���i�ǉ�
Route::get('/add/{id}', 'OrderController@add')->where(['id'=>'[0-9]+']);
//���i�폜
Route::get('/remove/{id}', 'OrderController@remove')->where(['id'=>'[0-9]+']);
//�J�[�g
Route::get('/cart', 'OrderController@cart')->name('cart');


//�Ǘ����
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
//�Ǘ��҃��O�C����z�[��
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

