<?php


/**
 * Translation helper for Mustache templates.
 */
class Helper_I18N extends I18N
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = self::translate($text);
		return $render ? $render($text) : $text;
	}

	public function languages()
	{
		return array_values(self::$config);
	}
}
