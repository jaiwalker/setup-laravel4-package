<?php namespace Jai\Newpackage\Controllers;


//use Illuminate\Support\ServiceProvider;
class newpackageController extends \BaseController
{
    public function index()
    {
        
         return \View::make('newpackage::newpackageview')->with('route_name','This is called from newpackage controller');
    }
}