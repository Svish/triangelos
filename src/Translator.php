<?php


/**
 * Translator for Mustache templates.
 */
class Translator
{
	protected static $config;
	protected static $current;
	protected static $strings;
	

	public static function translate($string)
	{
		$keys = explode('|', $string);
		$strings = &self::$strings;

		while ($key = array_shift($keys))
		{
			if( ! array_key_exists($key, $strings))
				return $string;
			$strings = &$strings[$key];
		}
		return $strings;
	}
	

	public static function init($host)
	{
		// For dev envs
		if(in_array($host, ['localhost', 'triangelos.geekality.net']))
			$host = 'triangelos.net';


		// Get host configuration
		self::$config = parse_ini_file(CONFIG.'hosts.ini', true, INI_SCANNER_RAW);
		foreach(self::$config as $key => &$val)
		{
			$val['href'] = 'http://'.$key;
			$val['host'] = $key;
		}


		// Find config for current domain
		if( ! array_key_exists($host, self::$config))
			HTTP::exit_status(404, 'Unconfigured hostname: '.$host);
		self::$current = &self::$config[$host];
		extract(self::$current);


		// Set constants and locale
		define('LANG', $lang);
		define('LOCALE', $locale);
		define('CACHE', DOCROOT.'.cache'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR);
		define('CONTENT', DOCROOT.'__'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR);

		$locales = array_map('trim', explode(',', $locales.','));
		call_user_func_array('setlocale', [LC_ALL, $locales]);
		setlocale(LC_NUMERIC, 'C');


		// Get strings
		$strings = CONTENT.$lang.'.inc';
		self::$strings = file_exists($strings) ? require $strings : [];
	}
}
