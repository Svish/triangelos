<?php


/**
 * Translator helper.
 */
class Translator
{
	private $strings = [];
	private function __construct()
	{
		if(file_exists(STRINGS))
			$this->strings = require STRINGS;
	}

	public function translate($text)
	{
		return array_key_exists($text, $this->strings)
			? $this->strings[$text]
			: $text;
	}

	public function __invoke($text, Mustache_LambdaHelper $helper = null)
	{
		return $helper->render($this->translate($text));
	}

	private static $instance;
	public static function instance()
	{
		if( ! self::$instance)
			self::$instance = new self();
		return self::$instance;
	}
}
