<?php


/**
 * Trim times.
 */
class Helper_TimeTrim
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = str_replace(':00', '', $text);
		return $render ? $render($text) : $text;
	}
}
