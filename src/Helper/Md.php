<?php

/**
 * Markdown helper for Mustache templates.
 */
class Helper_Md
{
	const EXT = '.md';


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
		if($render)
			$name = $render($name);

		foreach($this->alternatives($name ?: $this->url) as $file)
		{
			if( ! file_exists($file))
				continue;

			$md = File::get($file);
			$md = Markdown::render($md);
			return $md;
		}
	}


	/**
	 * Yields paths the markdown file could be.
	 */
	protected function alternatives($name)
	{
		// Try as is
		yield CONTENT.$name.self::EXT;
		yield CONTENT.'../'.$name.self::EXT;

		// Try with extension removed
		$name = substr($name, 0, strrpos($name, '.'));
		yield CONTENT.$name.self::EXT;
		yield CONTENT.'../'.$name.self::EXT;
	}
}
