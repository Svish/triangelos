<?php


/**
 * Translator for Mustache templates.
 */
class Helper_I18N extends I18N
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
