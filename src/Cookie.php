<?php


/**
 * Cookie helper.
 */
class Cookie
{
	const COOKIE_TIMEOUT = 15552000; // 180 days


	/**
	 * Get cookie value.
	 */
	public static function get($name, $default = null)
	{
		return array_key_exists($name, $_COOKIE) ? $_COOKIE[$name] : $default;
	}



	/**
	 * Set cookie value.
	 */
	public static function set($name, $value, $timeout = self::COOKIE_TIMEOUT, $domain = BASE_URI)
	{
		setcookie($name, $value, time()+$timeout, $domain);
	}



	/**
	 * Remove a cookie.
	 */
	public static function remove($name, $domain = BASE_URI)
	{
		unset($_COOKIE[$name]);
		setcookie($name, null, -1, $domain);
	}



	/**
	 * Refresh cookie with new timout.
	 */
	public static function refresh($name, $timeout = self::COOKIE_TIMEOUT, $domain = BASE_URI)
	{
		if(array_key_exists($name, $_COOKIE))
			setcookie($name, $_COOKIE[$name], time()+$timeout, $domain);
	}


}
