<?php


/**
 * Cache helper.
 */
class Cache
{
	const DIR = CACHE;
	private $dir;
	protected $valid;


	/**
	 * Creates a new cache instance.
	 *
	 * @param id Identifier for this cache
	 * @param language_specific True if cache should be per LANG
	 * @param validator Optional callable for validating the cache when getting
	 */
	public function __construct($id, $language_specific = false, $validator = null)
	{
		$this->valid = $validator ?: $this;

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

		// Try get data
		$data = $this->_get($path);
		$valid = $this->valid;
        if($data !== NULL && $valid(filemtime($path), $key))
			return unserialize($data);

		// Call and store default if callable
		if(is_callable($default))
		{
			$default = $default($key);
			return $this->_set($path, $default);
		}

		// Otherwise just return default
		return $default;
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
	 * Default validation check.
	 */
	public function __invoke($mtime, $key)
	{
		return true;
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
