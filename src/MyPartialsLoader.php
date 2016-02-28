<?php

/**
 * Custom Mustache Template filesystem Loader implementation.
 */
class MyPartialsLoader extends MyLoader
{
	protected function loadFile($name)
	{
		$tmpl = parent::loadFile($name);

		// Strip out other than content if BLOCKS file
		if(preg_match('%\{\{\$\s*content*\}\}(.+)\{\{\/\s*content*\}\}%s', $tmpl, $regs))
			return $regs[1];
		else
			return $tmpl;
	}
}
