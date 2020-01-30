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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/conversation','ConversationController@index')->name('conversation');
Route::get('/conversation/{user}','ConversationController@show')
	->middleware('can:talkTo,user')
	->name('conversation.show');
Route::post('/conversation/{user}','ConversationController@store')->middleware('can:talkTo,user');


