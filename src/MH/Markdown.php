<?php

/**
 * Markdown importer for Mustache templates.
 */
class MH_Markdown
{
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
		
		throw new Mustache_Exception_UnknownTemplateException($string);
	}


	protected function alternatives($file)
	{
		yield CONTENT.$file.'.md';
		yield CONTENT.'..'.DIRECTORY_SEPARATOR.$file.'.md';
	}
}
