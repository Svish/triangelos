<?php

use Mustache\Engine;

/**
 * Mustache_Engine wrapper with some defaults and other stuff.
 */
class Mustache
{
	const APP = 'src'.DS.'_views'.DS;
	const LIB = 'vendor'.DS.'geekality'.DS.'weblib'.DS.'src'.DS.'_views'.DS;
	const I18N = '_'.LANG.DS;


	public static function engine(string $template = null, array $options = [])
	{
		$paths = [ 
			self::I18N.$template,
			self::APP.$template,
			self::I18N,
			self::APP,
			self::LIB,
			];

		if($template)
			$partials = $paths;

		$templates = array_slice($paths, 2);

		return new Engine($templates, $partials ?? null, $options);
	}
}
