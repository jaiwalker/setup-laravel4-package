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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/home', 'HomeController@showWelcome');

Route::get('/hello', function(){
    //echo Walkthrough::hello();
    return View::make('Walkthrough::hello');
});

Route::get('/package', function(){
		echo Newpackage::hello();
	});
