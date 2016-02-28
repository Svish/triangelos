<?php


/**
 * Split string into separate css classes.
 */
class Helper_CssClass
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		if($render)
			$text = $render($text);

		$text = trim($text);

		if( ! empty($text))
			return " class=\"$text\" ";
	}
}
