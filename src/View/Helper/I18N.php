<?php

namespace View\Helper;
use Mustache_LambdaHelper as LH;
use I18N as I;
use Config;


/**
 * Translation helper for Mustache templates.
 */
class I18N
{
	public function __invoke($text, LH $render = null)
	{
		if($render)
			$text = $render($text);

		return I::translate($text);
	}

	/**
	 * Yield language options.
	 */
	public function options()
	{
		$hosts = Config::hosts();

		// Current host first
		$info = $hosts[HOST];
		$info['host'] = HOST;
		yield $info;

		// Then the rest
		foreach($hosts as $host => $info)
			if($host != HOST && $host != 'test')
			{
				$info['host'] = $host;
				yield $info;
			}
	}
}
