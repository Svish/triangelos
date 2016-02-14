<?php

class Mustache
{
	public static function engine()
	{
		return new Mustache_Engine([
			'cache' => CACHE.__CLASS__,
			'loader' => new MyLoader,
			'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
			]);
	}
}
