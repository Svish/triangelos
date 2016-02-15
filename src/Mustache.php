<?php

class Mustache
{
	public static function engine()
	{
		return new Mustache_Engine([
			//'cache' => CACHE.__CLASS__,
			'loader' => new MyLoader,
			'partials_loader' => new MyPartialsLoader,
			'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
			]);
	}
}
