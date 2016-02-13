<?php

/**
 * Pages.
 */
class Controller_Page extends Controller
{
	private $ctx;

	public function get($url, $context = [])
	{
		$url = ltrim($url, '/') ?: 'index';
		$this->ctx = [
			'this' => $url,
			'css' => Controller_Less::config()->global,
			'js' => Controller_Javascript::config()->global,
			'lang' => LANG,
			'isProd' => ENV == 'prod',
			'_' => new Helper_Translator,
		];

		try
		{
			header('content-type: text/html; charset=utf-8');
			echo Mustache::engine()->render($url, $this);
		}
		catch(Mustache_Exception_UnknownTemplateException $e)
		{
			throw new HTTP_Exception("No page found for the url '$url'.", 404);
		}
	}

	public function __get($key)
	{
		return $this->ctx[$key];
	}

	public function __isset($key)
	{
		// Already set?
		if(array_key_exists($key, $this->ctx))
			return true;

		// Class?
		foreach($this->alternatives($key) as $name)
			if(class_exists($name))
			{
				$this->ctx[$key] = new $name($this);
				return true;
			}

		return false;
	}

	private function alternatives($key)
	{
		$key = ucfirst($key);
		yield 'Model_'.$key;
		yield 'Helper_'.$key;
	}
}
