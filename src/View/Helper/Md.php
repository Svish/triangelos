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
	const DIR = [ L10N , I18N ];


	/**
	 * Renders and returns the named markdown file.
	 */
	public function __invoke($text = null, Helper $render = null)
	{
		// Render: Text
		if($text)
			return Markdown::instance()->render($render ? $render($text) : $text);

		// Render: File according to path
		$filename = PATH;
		foreach(self::DIR as $dir)
		{
			$file = $dir . $filename . Markdown::EXT;

			$md = File::get($file, false);
			if($md === false)
				continue;

			if($render)
				$md = $render($md);

			return Markdown::instance()->render($md);
		}

		Log::warn("Could not find markdown file '$filename' in any of", self::DIR);
	}
}
