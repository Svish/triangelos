<?php

class Util
{
	/**
	 * Safe array get.
	 */
	public static function get($arr, $key, $default = null)
	{
		return array_key_exists($key, $arr)
			? $arr[$key]
			: $default;
	}

	/**
	 * Yields the sub paths of $url.
	 *
	 * false => a/b/c, a/b, a
	 * true  => a/b/c, b/c, c
	 */
	public static function sub_paths($url, $backwards = false)
	{
		$url = explode('/', $url);
		while( ! empty($url))
		{
			yield implode('/', $url);
			if($backwards)
				array_shift($url);
			else
				array_pop($url);
		}
	}


	/**
	 * String starts with.
	 */
	public static function starts_with($haystack, $needle)
	{
		return $needle === "" || strpos($haystack, $needle) === 0;
	}

	/**
	 * String ends with.
	 */
	public static function ends_with($haystack, $needle)
	{
		return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
	}



	/**
	 * Returns an array containing only the whitelisted keys.
	 */
	public static function array_whitelist(array $array, array $whitelist)
	{
		return array_intersect_key($array, array_flip($whitelist));
	}

	/**
	 * Returns an array containing only the blaclisted keys.
	 */
	public static function array_blacklist(array $array, array $blacklist)
	{
		return array_diff_key($array, array_flip($blacklist));
	}

}
