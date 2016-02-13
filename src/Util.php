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
