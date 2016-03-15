<?php


/**
 * Cache helper.
 */
class Cache
{
	const DIR = CACHE;
	private $dir;
	private $ttl;



	public function __construct($id, $ttl = false, $language_specific = false)
	{
		if($ttl === false)
			$ttl = PHP_INT_MAX;
		$this->ttl = isset($_GET['no-cache']) ? 0 : $ttl;


		$this->dir = self::DIR.$id.DIRECTORY_SEPARATOR;
		if($language_specific)
			$this->dir .= LANG.DIRECTORY_SEPARATOR;
	}



	/**
	 * Reads and unserializes data from the cache file identified by $key.
	 */
	public function get($key, $default = NULL, $set = FALSE)
	{
		$path = $this->path($key);

		// Try get data, unless age greater than ttl
		$data = $this->_get($path);
		if($data !== NULL && $this->_age($path) <= $this->ttl)
			return unserialize($data);

		// Call default if Closure
		if($default instanceof Closure)
			$default = $default($key);

		// Return the default; optionally set
		return $set
			? $this->_set($path, $default)
			: $default;
	}
	private function _get($path)
	{
		return File::get($path);
	}



	/**
	 * Serializes and stores the $data in a cache file identified by $key.
	 */
	public function set($key, $data)
	{
		return $this->_set( $this->path($key) , $data);
	}
	private function _set($path, $data)
	{
		File::put($path, serialize($data));
		return $data;
	}



	/**
	 * Returns the age of the cache file in seconds.
	 */
	public function age($key)
	{
		return $this->_age( $this->path($key) );
	}
	private function _age($path)
	{
		return file_exists($path)
			? time() - filemtime($path)
			: PHP_INT_MAX;
	}



	/**
	 * Deletes cache file for $key if file is older than $time.
	 */
	public function validate($key, $time)
	{
		$key = $this->path($key);
		if(file_exists($key) && filemtime($key) <= $time)
			@unlink($key);
	}



	/**
	 * Return sanitized file path for $key.
	 */
	private function path($key)
	{
		return $this->dir.self::sanitize($key);
	}



	/**
	 * Make the key filename-friendly.
	 */
	private static function sanitize($key)
	{
		return preg_replace('/[^.a-z0-9_-]+/i', '-', $key);
	}



	/**
	 * Delete the cache for this $id.
	 */
	public function clear()
	{
		File::rdelete($this->dir);
	}



	/**
	 * Delete the whole cache.
	 */
	public static function clear_all()
	{
		File::rdelete(self::DIR);
	}
}
