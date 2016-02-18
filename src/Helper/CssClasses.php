<?php


/**
 * Split string into separate css classes.
 */
class Helper_CssClasses
{
	public function __invoke($string)
	{
		return preg_replace('/\W+/', ' ', $string);
	}
}
