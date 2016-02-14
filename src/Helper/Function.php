<?php


/**
 * PHP Function wrapper for Mustache templates.
 */
class Helper_Function
{
	private $function;

	public function __construct($function)
	{
		$this->function = $function;
	}


	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		$text = call_user_func_array($this->function, [$text]);
		return $helper ? $helper->render($text) : $text;
	}
}
