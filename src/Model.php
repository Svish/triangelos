<?php


/**
 * Base for model classes.
 */
abstract class Model
{
	const DIR = DOCROOT.'data'.DIRECTORY_SEPARATOR;


	/**
	 * Returns a new Model_$name.
	 */
	public static function __callStatic($name, $args)
	{
		$name = 'Model_'.ucfirst($name);
		return new $name;
	}



	/**
	 * Clears the cache for this class.
	 */
	public function clear_cache()
	{
		$cache = new Cache(get_class($this), 3600);
		$cache->clear();
	}
}
