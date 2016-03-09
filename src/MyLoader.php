<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyLoader implements Mustache_Loader
{
	const EXT = '.mustache';
	protected $templates = [];


	/**
	 * Load named template.
	 */
	public function load($name)
	{
		if ( ! array_key_exists($name, $this->templates))
			$this->templates[$name] = $this->loadFile($name);
		
		return $this->templates[$name];
	}


	/**
	 * Returns the first existing template among the alternatives.
	 */
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


	/**
	 * Yields alternative paths where the template could be.
	 */
	protected function alternatives($name)
	{
	 	// a/b/c, a/b, a
		foreach(Util::sub_paths($name) as $x)
	 		// a/b/c, b/c, c
			foreach(Util::sub_paths($x, true) as $y)
			{
				yield CONTENT.$y.self::EXT;
				yield CONTENT.'../'.$y.self::EXT;
			}
	}
}
