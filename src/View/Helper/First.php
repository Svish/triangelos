<?php

namespace View\Helper;

use Mustache_LambdaHelper as Helper;


/**
 * Helper: First.
 * 
 * Keeps first item.
 * 
 */
class First
{
	public function __invoke($arr = '', Helper $render = null)
	{
		$arr = $render ? $render($arr) : $arr;

		return is_array($arr)
			? reset($arr)
			: $arr;

	}
}
