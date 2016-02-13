<?php


/**
 * Cache helper.
 */
class Cache
{
	const DIR = CACHE;
	private $dir;


	public static function init($id)
	{
		return new self($id);
	}

	public function __construct($id)
	{
		$this->dir = self::DIR.$id.DIRECTORY_SEPARATOR;
	}



	/**
	 * Reads and unserializes data from the cache file identified by $key.
	 * Returns $default if the cache file doesn't exist.
	 */
	public function get($key, $default = NULL)
	{
		$key = $this->path($key);
		$data = File::get($key);
		return $data !== NULL
			? unserialize($data)
			: $default;
	}


	/**
	 * Serializes and stores the $data in a cache file identified by $key.
	 */
	public function set($key, $data)
	{
		$key = $this->path($key);
		File::put($key, serialize($data));
		return $data;
	}


	/**
	 * Returns the age of the cache file in seconds.
	 */
	public function age($key)
	{
		$path = $this->path($key);
		return file_exists($path)
			? time() - filemtime($path)
			: PHP_INT_MAX;
	}


	/**
	 * Deletes cache file for $key if file is older than $time.
	 */
	public function validate($key, $time)
	{
		$path = $this->path($key);
		if(file_exists($path) && filemtime($path) <= $time)
			@unlink($path);
	}


	public function path($key)
	{
		File::check($this->dir);
		return $this->dir . self::sanitize($key);
	}



	private static function sanitize($key)
	{
		return preg_replace('/[^.a-z0-9_-]+/i', '-', $key);
	}



	public static function clear_all()
	{
		File::rdelete(self::DIR);
	}
}
