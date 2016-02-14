<?php


/**
 * Translator for Mustache templates.
 */
class Helper_Translator
{
	private $strings;
	private $languages;


	public function __construct()
	{
		$this->strings = require STRINGS;
		$this->languages = parse_ini_file(CONFIG.'sites.ini', true, INI_SCANNER_RAW);
		foreach($this->languages as $key => &$val)
		{
			$val['href'] = 'http://'.$key;
			$val['host'] = $key;
		}
	}


	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		$text = array_key_exists($text, $this->strings)
			? $this->strings[$text]
			: $text;
		return $helper->render($text);
	}


	public function languages()
	{
		return array_values($this->languages);
	}
}
