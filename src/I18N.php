<?php

/**
 * Translator for Mustache templates.
 */
class I18N
{
	use Candy\InstanceCallable;

	private $_config;
	private $_current;

	private $_strings;
	
	private $_rkey;
	private $_rval;


	private function __construct(string $host)
	{

		// Get host configuration
		$this->_config = Config::hosts(INI_SCANNER_RAW);

		// For dev envs
		if(in_array($host, $this->_config['test'] ?? []) || ip2long($host) !== false)
			$host = 'triangelos.net';

		
		// Find config for current domain
		if( ! array_key_exists($host, $this->_config))
			HTTP::plain_exit(404, 'Unconfigured hostname: '.$host);

		$this->_current = &$this->_config[$host];
		extract($this->_current);


		// Set constants and locale
		define('LANG', $lang);
		define('LOCALE', $locale);
		define('HOST', $host);
		define('I18N', 'i18n'.DS);
		define('L10N', 'i18n'.DS."_$lang".DS);

		setlocale(LC_ALL, ...$locales);
		setlocale(LC_NUMERIC, 'C');


		// Get strings
		$i18n = parse_ini_file(I18N.'_.ini', INI_SCANNER_RAW);
		$l10n = parse_ini_file(L10N.'_.ini', INI_SCANNER_RAW);
		$this->_strings = Util::merge($i18n, $l10n);

		// Get replacements
		$replacements = array_filter($this->_strings, 'is_string');
		$this->_rkey = array_keys($replacements);
		$this->_rval = array_values($replacements);
	}

	private function strings()
	{
		return $this->_strings;
	}


	private function translate($text)
	{
		// General string
		if(strpos($text, '/') === false)
			return str_replace($this->_rkey, $this->_rval, $text);

		// Path to something specific
		$keys = explode('/', $text);
		$strings = &$this->_strings;

		while($key = array_shift($keys))
		{
			$key = trim($key);
			if( ! array_key_exists($key, $strings))
				return $key;
			$strings = &$strings[$key];
		}
		return $strings;
	}
}
