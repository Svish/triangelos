<?php

/**
 * SVG importer for Mustache templates.
 */
class Helper_Svg
{
	const DIR = DOCROOT.'_'.DIRECTORY_SEPARATOR;

	public function __invoke($name)
	{
		$opt = explode(';', $name, 2);
		
		$svg = File::get(self::DIR.$opt[0].'.svg');

		if(isset($opt[1]))
			$svg = str_replace('<svg ', "<svg {$opt[1]} ", $svg);

		return $svg;
	}
}
