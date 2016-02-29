<?php


/**
 * First line.
 */
class Helper_FirstLine
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = explode('<br>', $text, 2)[0];
		return $render ? $render($text) : $text;
	}
}
