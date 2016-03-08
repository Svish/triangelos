<?php

/**
 * SVG importer for Mustache templates.
 *
 * If the name includes a ";" everything
 * following it will be added to the <svg> 
 * tag as attributes.
 */
class Helper_Svg
{
	const DIR = DOCROOT.'_'.DIRECTORY_SEPARATOR.'icon'.DIRECTORY_SEPARATOR;

	public function __invoke($name, Mustache_LambdaHelper $render = null)
	{
		if($render)
			$name = $render($name);

		$opt = explode(';', $name, 2);
		
		$svg = File::get(self::DIR.$opt[0].'.svg');

		if(isset($opt[1]))
			$svg = str_replace('<svg ', "<svg {$opt[1]} ", $svg);

		return $svg;
	}
}
