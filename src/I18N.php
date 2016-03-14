<?php

/**
 * Short function for translations.
 */
function __($text)
{
	return I18N::translate($text);
}


/**
 * Translator for Mustache templates.
 */
class I18N
{
	protected static $config;
	protected static $current;
	protected static $strings;
	
	protected static $rkey;
	protected static $rval;


	public static function translate($text)
	{
		if( ! self::$config)
			throw new Exception(__METHOD__.' called before init');
		
		// General string
		if(strpos($text, '/') === false)
			return str_replace(self::$rkey, self::$rval, $text);

		// Path to something specific
		$keys = explode('/', $text);
		$strings = &self::$strings;

		while ($key = array_shift($keys))
		{
			$key = trim($key);
			if( ! array_key_exists($key, $strings))
				return $text;
			$strings = &$strings[$key];
		}
		return $strings;
	}
	

	public static function init($host)
	{
		// For dev envs
		if(in_array($host, ['localhost', 'triangelos.geekality.net']) || ip2long($host) !== false)
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
		define('HOST', $host);
		define('CONTENT', DOCROOT.'__'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR);

		$locales = array_map('trim', explode(',', $locales.','));
		call_user_func_array('setlocale', [LC_ALL, $locales]);
		setlocale(LC_NUMERIC, 'C');


		// Get strings
		$strings = CONTENT.$lang.'.inc';
		self::$strings = file_exists($strings) ? require $strings : [];
		self::$strings = Util::merge(require CONTENT.'../default.inc', self::$strings);

		// Get replacements
		$replacements = array_filter(self::$strings, 'is_string');
		self::$rkey = array_keys($replacements);
		self::$rval = array_values($replacements);
	}
}
