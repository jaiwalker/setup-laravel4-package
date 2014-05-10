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

// Route::get('/', function()
// {
// 	return View::make('hello');
// });

Route::get('/packagecontroller', 'Jai\Newpackage\Controllers\newpackageController@index');

Route::get('/packageroute', function(){    
	     echo " package route is working ";
	});

Route::get('/packageview', function()
{
	return View::make('newpackage::newpackageview')->with('route_name','This is called from packageview');
});

