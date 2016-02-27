<?php


/**
 * Split string into separate css classes.
 */
class Helper_CssClass
{
	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		if($helper)
			$text = $helper->render($text);

		$text = trim($text);

		if( ! empty($text))
			return " class=\"$text\" ";
	}
}
