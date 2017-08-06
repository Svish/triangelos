<?php

namespace View\Helper;

use Mustache_LambdaHelper as Helper;

use Log;
use File;
use Markdown;
use Error\InternalNotFound as Error;


/**
 * Helper: Markdown
 * 
 * Localized Markdown helper that looks for markdown files
 */
class Md
{
	const DIR = [
		'i18n'.DS,
		'i18n'.DS.'_'.LANG.DS,
	];


	/**
	 * Renders and returns the named markdown file.
	 */
	public function __invoke($text = null, Helper $render = null)
	{
		if($render)
			$text = $render($text);


		// Render: Text
		if($text)
			return Markdown::instance()->render($text);


		// Render: File according to path
		$filename = PATH;
		foreach(self::DIR as $dir)
		{
			$file = $dir . $filename . Markdown::EXT;

			$md = File::get($file, false);
			if($md === false)
				continue;

			return Markdown::instance()->render($md);
		}

		Log::warn('Could not find markdown file', $filename, 'in any of', self::DIR);
	}
}
