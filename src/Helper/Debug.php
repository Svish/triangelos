<?php


/**
 * Dumb an object.
 */
class Helper_Debug
{
	public function __invoke($object)
	{
		return print_r($object, true);
	}
}
