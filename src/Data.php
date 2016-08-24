<?php

/**
 * Base class for file data objects.
 */
abstract class Data implements JsonSerializable
{
	private $file;
	private $properties = [];

	public function __construct(array $properties, $file = null)
	{
		$this->file = $file;
		if($this->file)
			$this->load();

		$this->set($properties);
	}



	public function load()
	{
		$json = File::get($this->file);
		$this->properties = json_decode($json, true);
		return $this;
	}

	public function save()
	{
		File::put($this->file, json_encode($this, JSON_PRETTY_PRINT));
		return $this;
	}

	public function set(array $properties)
	{
		foreach($properties as $k => $v)
			$this->$k = $v;
		return $this;
	}



	public function __get($key)
	{
		return array_key_exists($key, $this->properties)
			? $this->properties[$key]
			: null;
	}

	public function __set($key, $value)
	{
		$this->properties[$key] = $value;
	}
	
	public function __isset($key)
	{
		return array_key_exists($key, $this->properties);
	}
	
	public function __unset($key)
	{
		unset($this->properties[$key]);
	}



	protected $serialize = [];
	public function jsonSerialize()
	{
		return empty($this->serialize) 
			? $this->properties
			: Util::array_whitelist($this->properties, $this->serialize);
	}
}
