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
}
