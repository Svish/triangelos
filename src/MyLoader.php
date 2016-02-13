<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyLoader implements Mustache_Loader
{
	private $templates = [];

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
		yield CONTENT.$name.'.mustache';
		yield CONTENT.'..'.DIRECTORY_SEPARATOR.$name.'.mustache';
	}
}
