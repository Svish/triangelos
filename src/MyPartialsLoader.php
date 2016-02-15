<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyPartialsLoader extends MyLoader
{
	protected function loadFile($name)
	{
		$tmpl = parent::loadFile($name);

		if(preg_match('%\{\{\$\s*content*\}\}(.+)\{\{\/\s*content*\}\}%s', $tmpl, $regs))
			return $regs[1];
		else
			return $tmpl;
	}
}
