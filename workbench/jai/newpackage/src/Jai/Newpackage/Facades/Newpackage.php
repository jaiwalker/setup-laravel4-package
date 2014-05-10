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
