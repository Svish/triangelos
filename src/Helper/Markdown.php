<?php

/**
 * Markdown importer for Mustache templates.
 */
class Helper_Markdown
{
	const EXT = '.md';
	const DIR = DOCROOT.'_'.DIRECTORY_SEPARATOR;

	// TODO: Cache $name => $file

	private $url;
	public function __construct($ctx)
	{
		$this->url = $ctx->this;
	}


	/**
	 * Renders and returns the named markdown file.
	 */
	public function __invoke($name = null, Mustache_LambdaHelper $render = null)
	{
		foreach($this->alternatives($name ?: $this->url) as $file)
		{
			if( ! file_exists($file))
				continue;

			$md = File::get($file);
			$md = Markdown::render($md);
			return $render ? $render($md) : $md;
		}
	}


	/**
	 * Yields paths the markdown file could be.
	 */
	protected function alternatives($name)
	{
	 	// a/b/c, b/c, c
		foreach(Util::sub_paths($name, true) as $x)
	 		// a/b/c, a/b, a
			foreach(Util::sub_paths($x) as $y)
			{
				yield CONTENT.$y.self::EXT;
				yield CONTENT.'../'.$y.self::EXT;
			}
	}
}
