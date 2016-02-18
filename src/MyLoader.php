<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyLoader implements Mustache_Loader
{
	const EXT = '.mustache';

	protected $templates = [];

	// TODO: Cache template map?

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
		foreach(Util::sub_paths($name, true) as $x)
		foreach(Util::sub_paths($x) as $y)
		{
			yield CONTENT.$y.self::EXT;
			yield CONTENT.'../'.$y.self::EXT;
		}
	}
}
