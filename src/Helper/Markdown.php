<?php

/**
 * Markdown importer for Mustache templates.
 */
class Helper_Markdown
{
	const EXT = '.md';
	const DIR = DOCROOT.'_'.DIRECTORY_SEPARATOR;


	private $url;
	public function __construct($ctx)
	{
		$this->url = $ctx->this;
	}


	public function __invoke($string = null, Mustache_LambdaHelper $helper = null)
	{
		foreach($this->alternatives($string ?: $this->url) as $file)
		{
			if( ! file_exists($file))
				continue;

			$md = File::get($file);
			$md = Markdown::render($md);
			return $helper ? $helper->render($md) : $md;
		}
	}


	protected function alternatives($name)
	{
		foreach(Util::sub_paths($name, true) as $x)
		foreach(Util::sub_paths($x) as $y)
		{
			yield CONTENT.$y.self::EXT;
			yield CONTENT.'../'.$y.self::EXT;
		}
	}
}
