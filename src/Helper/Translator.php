<?php


/**
 * Translator for Mustache templates.
 */
class Helper_Translator extends Translator
{
	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		$text = self::translate($text);
		return $helper ? $helper->render($text) : $text;
	}


	public function languages()
	{
		return array_values(self::$config);
	}
}
