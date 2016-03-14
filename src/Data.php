<?php

/**
 * Base class for data objects.
 */
abstract class Data implements JsonSerializable
{
	private $file;
	private $properties;

	public function __construct(array $properties, $file = null)
	{
		$this->properties = $properties;
		$this->file = $file;
	}



	public function save()
	{
		File::put($this->file, json_encode($this, JSON_PRETTY_PRINT));
	}



	public function __get($key)
	{
		return $this->properties[$key];
	}
	
	public function __isset($key)
	{
		return array_key_exists($key, $this->properties);
	}

	public function __set($key, $value)
	{
		$this->properties[$key] = $value;
	}



	protected $serialize = [];
	public function jsonSerialize()
	{
		return empty($this->serialize) 
			? $this->properties
			: Util::array_whitelist($this->properties, $this->serialize);
	}
}
