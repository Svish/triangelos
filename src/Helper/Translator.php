<?php


/**
 * Translator for Mustache templates.
 */
class Helper_Translator
{
	public function __construct()
	{
		$this->strings = require STRINGS;
	}

	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		$text = array_key_exists($text, $this->strings)
			? $this->strings[$text]
			: $text;
		return $helper->render($text);
	}
}
