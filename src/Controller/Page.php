<?php

/**
 * Pages.
 */
class Controller_Page extends Controller
{
	public function get($url, $context = [])
	{
		$url = ltrim($url, '/') ?: 'index';

		try
		{
			header('content-type: text/html; charset=utf-8');
			echo Mustache::engine()->render($url, $context + [
				'css' => Controller_Less::config(),
				'js' => Controller_Javascript::config(),
				'lang' => LANG,
				'this' => $url,
			]);
		}
		catch(Mustache_Exception_UnknownTemplateException $e)
		{
			throw new HTTP_Exception("No page found for the url '$url'.", 404);
		}
	}

}
