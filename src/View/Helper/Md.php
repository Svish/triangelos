<?php

namespace View\Helper;

use Mustache_LambdaHelper as Helper;

use File, Markdown;


/**
 * Markdown helper for Mustache templates.
 */
class Md
{
	const EXT = '.md';

	const DI = 'i18n'.DS;
	const DL = 'i18n'.DS.'_'.LANG.DS;


	/**
	 * Renders and returns the named markdown file.
	 */
	public function __invoke($name = null, Helper $r = null)
	{
		if($r)
			$name = $r($name);

		if( ! $name)
			$name = PATH;

		$options = [
			self::DL.$name.self::EXT,
			self::DI.$name.self::EXT,
		];

		foreach($options as $file)
		{
			$md = File::get($file, false);
			if($md === false)
				continue;

			return Markdown::render($md);
		}

		return implode('<br>', $options);
	}
}
