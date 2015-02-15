<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('users','UsersController');
Route::resource('transactions','TransactionsController');
Route::resource('items','ItemsController');
Route::post('users/login', array('as' => 'user.login', 'uses' => 'UsersController@login'));
Route::get('transactionspr', array('as' => 'transactions.pr', 'uses' => 'TransactionsController@getpr'));
Route::get('transactionswh', array('as' => 'transactions.wh', 'uses' => 'TransactionsController@getwh'));
Route::get('transactionsall', array('as' => 'transactions.all', 'uses' => 'TransactionsController@getall'));
