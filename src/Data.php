<?php

/**
 * Base class for file data objects.
 */
abstract class Data
{
	const DIR = DOCROOT.'data'.DIRECTORY_SEPARATOR;
	protected $data = [];



	public static function __callStatic($name, $args)
	{
		$name = __CLASS__.'_'.ucfirst($name);
		$r = new ReflectionClass($name);
		return $r->newInstanceArgs($args);
	}

	public function __call($method, $args)
	{
		if(is_callable($this->data[$method]))
			return call_user_func_array($this->data[$method], $args);
	}



	public function __get($key)
	{
		return array_key_exists($key, $this->data)
			? $this->data[$key]
			: null;
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}
	
	public function __isset($key)
	{
		return array_key_exists($key, $this->data);
	}
	
	public function __unset($key)
	{
		unset($this->data[$key]);
	}
}
