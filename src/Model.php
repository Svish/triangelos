<?php


/**
 * Base for model classes.
 */
abstract class Model
{
	const DIR = DOCROOT.'data'.DIRECTORY_SEPARATOR;


	public static function get($name)
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
