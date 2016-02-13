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
			'_' => new MH_Translator,
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
		// ALready set
		if(array_key_exists($key, $this->ctx))
			return true;

		// Class?
		$helper = 'MH_'.ucfirst($key);
		if(class_exists($helper))
		{
			$this->ctx[$key] = new $helper($this);
			return true;
		}

		return false;
	}

}
