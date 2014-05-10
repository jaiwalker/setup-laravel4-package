## Laravel PHP Framework - jai Understanding laravel prackges 

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) 

This is just for understanidg how packages in laravle works :

I have spend days looking for the appropriate guide - how to use controller, routes and config , after doing some research my self I found few Important that not  explained.

Lets get to the business:

Install Latest version of laravel via composer if you like. ( You can still use laravel with out composer so its up to you  ).

Once laravel is installed give its storage folder respective premissions and try and run home page.

Now I suppose Eveything is working fine right !!!!

Lets create a package  I am doing it via composer  ( using composer is better for developer)

before we start  make sure that laravel debug is set to true ( app/config/app.php  debug:true) by default laravel is now shipped with debug off, trunning it on will help you to identify and google error quickly or else you would be looking at "oops message " which shits you ...

ok ! now 

laravel packages are build from workbench ... there is whole different concept to this ..anyways
 
 1)
 got  to app/config/workbench.php add your name and email here  this is  Important as packages structure will be based onthis.
 
 2) Use Command Line Interface to navigate to Laravel 4 root folder, and then run:

    php artisan workbench jai/newpackage --resources

--resources will create  controllers and other imp folder 
Note that `jai` represents a vendor (company name, personal name etc.), and `cms` represents a package name.
You get a message  in CLI 'package workench created ......'
 Now there should be a folder created "workbench/jai/newpackage...... "  

## Package Setup

4)  Now we need to link the laravle app with  the package created  so 
	Open `/app/config/app.php` to add a Service Provider to the end of the providers array:

	'providers' => array(
	  // --
	  'Jai\Newpackage\NewpackageServiceProvider',
	),
   make sure that first letters are in cap ( Jai and Newpackage) J and N are in capitals

5) To create a main package class generate the file named `Newpackage.php` inside a path `/workbench/jai/Newpackage/src/Jai/Newpackage/` with the following code inside:

make sure that capitals are entered where ever necessary!!!

	<?php namespace Jai\Newpackage;

	class Newpackage {

		public static function hello(){
			return "What's up .....!";
		}

	}

6) Register the new class with the Laravel’s IoC Container by editing Package Service Provider file `/workbench/jai/newpackage/src/Jai/Newpackage/WalkthroughServiceProvider.php` and make sure that the register method looks like this:

	public function register()
	{
		$this->app['newpackage'] = $this->app->share(function($app)
		{
			return new Newpackage;
		});
	}

**Note: If your service provider cannot be found, run the php artisan dump-autoload command from your application's root directory.
 This NOT equall to running  composer dump autoload
**

## Package Facade Generation

Although generating a facade is not necessary, Facade allows you to do something like this:

	echo Newpackage::hello();

7) Create a folder named `Facades` under following path `/workbench/jai/newpackage/src/Jai/Newpackage/`

8) Inside the `Facades` folder create a file named `Newpackage.php` with the following content:

	<?php namespace Jai\Newpackage\Facades;

	use Illuminate\Support\Facades\Facade;

	class Newpackage extends Facade {

	  /**
	   * Get the registered name of the component.
	   *
	   * @return string
	   */
	  protected static function getFacadeAccessor() { return 'newpackage'; }

	}

9) Add the following to the register method in '/workbench/jai/newpackage/src/Jai/Newpackage/WalkthroughServiceProvider.php' of your Service Provider file:

	$this->app->booting(function()
	{
	  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
	  $loader->alias('Walkthrough', 'Orangehill\Walkthrough\Facades\Walkthrough');
	});

	SO now your register  method will look like this 

	public function register()
	{
		$this->app['newpackage'] = $this->app->share(function($app)
				{
					return new Newpackage;
				});

		$this->app->booting(function()
		{
		  $loader = \Illuminate\Foundation\AliasLoader::getInstance();
		  $loader->alias('Newpackage', 'Jai\Newpackage\Facades\Newpackage');
		});
	}


This allows the facade to work without the adding it to the Alias array in app/config/app.php

## Browser Test

10) Edit your `/app/routes.php` file and add a route to test if a package works:

	Route::get('/package', function(){
		echo Newpackage::hello();
	});

If all went well you should see the `What's up .....` output in your browser after visiting the test URL.


Now adding routes !!!

As you can we can use the main routes  files, but in many cases you want your package to have a routes my itself hecne 

##Adding routes 

1) navigate to /workbench/jai/newpackage/src/'  and create a file routes.php  like this  
 
 	Route::get('/packageroute', function(){
     echo " package route is working ";
	});

2) Now we need to Include this route  on our package boot  so navigate to '/workbench/jai/newpackage/src/Jai/Newpackage/WalkthroughServiceProvider.php' Edit this file and  add this line in boot method
	
	include __DIR__ . '/../../routes.php';

	now Boot method should look like this 

	public function boot()
		{
			$this->package('orangehill/walkthrough');
			include __DIR__ . '/../../routes.php';
			
		}

3) To test this type in packageroute  and this show you "package route is working" .

##loading a view in package via package route.

1) This is pretty straight ...but nevetheless you need to make some adjustments to way you call them.
	create a view  in "/workbench/jai/newpackage/src/views/" folder namely "newpackageview.blade.php"

	<html>
	<head>
		<title> New package view</title>
	</head>
	<body>
		<p> This is our package view</p>
		{{ $route_name}}

	</body>
	</html>

2) From your  package route file  call this view like this 

	Route::get('/packageview', function()
	{
		return View::make('newpackage::newpackageview')->with('route_name','This is called from packageview');
	});

3) now  in the browse when you type packageview you should see

		This is our package view

	This is called from packageview

##  Using a controller 

1) using a controller is not that straight as you think it is , althought we have contraller folder we need to tell lavel to include controller folder   by editing  conposer.json file  which is /workbench/jai/newpackage folder and add the controllers folder

	"autoload": {
        "classmap": [
            "src/migrations"
            "src/controllers"
        ],
 
 2) make sure you add service provider namespace to global class  
 		navigate to /workbench/jai/newpackage/src/Jai/Newpackage/WalkthroughServiceProvider.php file edit it 
 		 add this on to top 

 		 <?php namespace Jai\Newpackage;

		use Illuminate\Support\ServiceProvider;

 3) now lets create a controller  navigate to /workbench/jai/newpackage/src/controllers  create a new file newpackageController.php

 	<?php namespace Jai\Newpackage\Controllers;

	class newpackageController extends \BaseController
	{
	    public function index()
	    {
	        return \View::make('newpackage::newpackageview')->with('route_name','This is called from newpackage controller');
	    }
	}


 make sure you get in '\' this will tell it look from source code.

 4) via command line navigate to laravel folder a run this command " php artisan dump-autoload" you should be see the following

	Generating optmised class loader..
	Running  for workbench [jai\newpackage]....

 what this will do ?? this now autoload the controller folder 
 How can I check this ??   got to /workbench/jai/newpackage/vendor/composer/autoload_classmap.php   this should have a  map in return array 
 like this already placed 
  " 'Jai\\Newpackage\\Controllers\\newpackageController' => $baseDir . '/src/controllers/newpackageController.php',"

  5)  now let s add a route  in /workbench/jai/newpackage/routes.php file

  	Route::get('/packagecontroller', 'Jai\Newpackage\Controllers\newpackageController@index');

  6) Now when you run "packagecontroller" in your url you will see this message in your browser

  	This is our package view

  	This is called from newpackage controller

 that is all for now  I will  be adding more stuff like  accessing config file , models , helpers and many more ...
 Follow me for more....https://github.com/jaiwalker/followers

 Jai.
 Walker.


### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
