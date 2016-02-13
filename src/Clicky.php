<?php

/**
 * Helper class for Clicky integration.
 */
class Clicky
{
	private static $api = 'https://in.getclicky.com/in.php';
	private static $parameters = ['type', 'href','title', 'ref', 'ua', 'ip_address', 'session_id', 'goal', 'custom'];
	private static $types = ['click', 'pageview', 'download', 'outbound', 'custom'];

	public static function log(array $data = null)
	{
		// Filter and append default values
		$data = Util::array_whitelist($data ?: [], self::$parameters)
			+ [
				'type' => self::$types[0],
				'ip_address' =>  @$_SERVER['REMOTE_ADDR'],
				'ref' => @$_SERVER['HTTP_REFERER'],
				'ua' => @$_SERVER['HTTP_USER_AGENT'],
				'href' => @$_SERVER['REQUEST_URI'],
				'site_id' => @constant('CLICKY_SITE_ID'),
				'sitekey_admin' => @constant('CLICKY_ADMIN_KEY'),
			];

		if(@$_SERVER['HTTP_DNT'])
			return;

		if( ! $data['site_id'] || ! $data['sitekey_admin'])
			return;

		if( ! in_array($data['type'], self::$types))
			throw new HTTP_Exception("Invalid clicky log type: {$data['type']}");

		$c = curl_init();
		curl_setopt_array($c, array
		(
			CURLOPT_URL => self::$api.'?'.http_build_query($data),
			CURLOPT_RETURNTRANSFER => TRUE,
		));

		curl_exec($c);
		curl_close($c);
	}

}
