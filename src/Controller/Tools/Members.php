<?php

/**
 * Controller for protected member area.
 */
class Controller_Tools_Members extends Controller_Tools
{
	public function before(array &$info)
	{
		parent::before($info);

	}

	public function get($id, $context = [])
	{
		var_dump(get_defined_vars());exit;
	}
}
