<?php

class Mustache
{
	public static function engine()
	{
		return new Mustache_Engine([
			'cache' => CACHE.__CLASS__,
			'loader' => new MyLoader,
			]);
	}
}
