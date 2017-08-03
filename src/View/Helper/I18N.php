<?php

namespace View\Helper;
use Mustache_LambdaHelper as LH;
use I18N as I;

/**
 * Translation helper for Mustache templates.
 */
class I18N extends I
{
	public function __invoke($text, LH $render = null)
	{
		if($render)
			$text = $render($text);

		return self::translate($text);
	}

	/**
	 * Yields language options, current first.
	 */
	public function options()
	{
		$info = self::$config[HOST];
		$info['host'] = HOST;
		yield $info;

		foreach(self::$config as $host => $info)
		{
			if($host != HOST)
			{
				$info['host'] = $host;
				yield $info;
			}
		}
	}
}
