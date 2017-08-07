<?php

namespace View\Helper;
use Mustache_LambdaHelper;


class Url
{
	public function __invoke($x = null, Mustache_LambdaHelper $render = null)
	{
		if(is_string($x) || is_null($x))
		{
			if($render)
				$x = $render($x);

			return strpos($x, '/') === 0
				? WEBROOT.ltrim($x, '/')
				: WEBBASE.$x;	
		}

		switch(get_class($x))
		{
			case 'Data\Album':
				return "music/album/{$x->id}";

			case 'Data\Track':
				return "music/album/{$x->id}";
		}
	}
}
	
