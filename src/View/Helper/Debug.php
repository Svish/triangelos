<?php

namespace View\Helper;

use Mustache_LambdaHelper as Helper;


/**
 * Helper: Debug.
 * 
 * Dumps whatever into a <pre>
 */
class Debug
{
	public function __invoke($x, Helper $render = null)
	{
		$x = $render ? $render($x) : $x;

		return '<pre>'.print_r($x, true).'</pre>';
	}
}
