<?php

/**
 * Handles normal pages.
 */
class Controller_Page extends SessionController
{
	private $ctx;
	private $path;

	public function before(array &$info)
	{
		parent::before($info);
		$this->path = trim($info['path'], '/') ?: 'index';
	}


	public function get($url, $context = [])
	{
		$url = ltrim($url, '/') ?: 'index';
		$this->ctx = $context + [
			'this' => $this->path,
			'class' => str_replace('/', ' ', $this->path),

			'user' => Model::get('user')->logged_in(),
			
			'css' => Controller_Less::config()->global,
			'js' => Controller_Javascript::config()->global,
			
			'isProd' => ENV == 'prod',
			
			'_' => new Helper_I18N,
			
			'_get' => $_GET,
			'_post' => $_POST,
		];

		try
		{
			header('content-type: text/html; charset=utf-8');
			echo Mustache::engine()->render($url, $this);
		}
		catch(Mustache_Exception_UnknownTemplateException $e)
		{
			throw new HTTP_Exception("Page '$url' not found", 404);
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

		// Constant?
		if(defined($key))
			return $this->set($key, constant($key));

		// Class?
		foreach($this->alternatives($key) as $name)
			if(class_exists($name))
				return $this->set($key, new $name($this));

		// Function?
		if(function_exists($key))
			return $this->set($key, new Helper_Function($key));

		return false;
	}

	private function set($key, $value)
	{
		$this->ctx[$key] = $value;
		return true;
	}

	private function alternatives($key)
	{
		$key = ucfirst($key);
		yield 'Helper_'.$key;
		yield 'Model_'.$key;
		yield $key;
	}
}
