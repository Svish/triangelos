<?php

/**
 * SVG importer for Mustache templates.
 */
class MH_Svg
{
	const DIR = DOCROOT.'_'.DIRECTORY_SEPARATOR;

	public function __invoke($filename)
	{
		return File::get(self::DIR.$filename.'.svg');
	}
}
