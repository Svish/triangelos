<?php


/**
 * Translator for Mustache templates.
 */
class Helper_I18N extends I18N
{
	private $rkey;
	private $rval;

	public function __construct()
	{
		$replacements = array_filter(self::$strings, 'is_string');
		$this->rkey = array_keys($replacements);
		$this->rval = array_values($replacements);
	}

	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		if(strpos($text, '/') !== false)
			$text = self::translate($text);
		else
			$text = str_replace($this->rkey, $this->rval, $text);
			
		return $render ? $render($text) : $text;
	}


	public function languages()
	{
		return array_values(self::$config);
	}
}
