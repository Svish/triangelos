<?php


/**
 * Trim times.
 */
class Helper_TimeTrim
{
	private $function;

	public function __construct($function)
	{
		$this->function = $function;
	}


	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = str_replace(':00', '', $text);
		return $render ? $render($text) : $text;
	}
}
