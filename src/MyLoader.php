<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyLoader implements Mustache_Loader
{
	const EXT = '.mustache';

	protected $templates = [];


	public function load($name)
	{
		if (!array_key_exists($name, $this->templates))
			$this->templates[$name] = $this->loadFile($name);
		
		return $this->templates[$name];
	}

	protected function loadFile($name)
	{
		foreach($this->alternatives($name) as $file)
		{
			$tmpl = File::get($file);
			if($tmpl)
				return $tmpl;
		}

		throw new Mustache_Exception_UnknownTemplateException($name);
	}

	protected function alternatives($name)
	{
		yield CONTENT.$name.self::EXT;
		yield CONTENT.'..'.DIRECTORY_SEPARATOR.$name.self::EXT;

		$parts = explode('/', $name);
		
		while($part = array_pop($parts))
		{
			yield CONTENT.$part.self::EXT;
			yield CONTENT.'..'.DIRECTORY_SEPARATOR.$part.self::EXT;	
		}
	}
}
