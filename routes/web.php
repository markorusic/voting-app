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

	if(Auth::guest())
		return view('welcome');	
	return redirect()->route('dashboard');

});

Route::get('/polls', 'PollController@index')->name('polls');
Route::get('/polls/{poll}', 'PollController@show'); 
Route::get('polls/{poll}/vote/{choice}', 'VotesController@store');

Auth::routes();


Route::middleware(['auth'])->group(function(){

	Route::get('/dashboard', 'PollController@create')->name('dashboard');
	Route::post('/dashboard', 'PollController@store')->name('newPoll');
	Route::delete('/dashboard/{poll}', 'PollController@destroy');
	
});


