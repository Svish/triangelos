<?php


/**
 * Available languages.
 */
class Model_Languages
{
	private $l;
	public function __construct()
	{
		$this->l = parse_ini_file(CONFIG.'sites.ini', true, INI_SCANNER_RAW);
		foreach($this->l as $key => &$val)
		{
			$val['href'] = 'http://'.$key;
			$val['host'] = $key;
		}
	}

	public function all()
	{
		return array_values($this->l);
	}
}
