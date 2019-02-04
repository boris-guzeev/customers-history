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

Route::get('/orders/history', 'OrdersController@history');

Route::get('/', 'OrdersController@index');
Route::get('/orders/list', 'OrdersController@list');

Route::get('/orders/demoCreate', 'OrdersController@demoCreate');
Route::get('/orders/demoUpdate', 'OrdersController@demoUpdate');
Route::get('/orders/demoDelete', 'OrdersController@demoDelete');

Route::resource('orders', 'OrdersController');