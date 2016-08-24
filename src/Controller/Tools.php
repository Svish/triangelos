<?php

/**
 * Controller for protected member area.
 */
class Controller_Tools extends Controller_Page
{
	public function before(array &$info)
	{
		parent::before($info);

		if( ! Model::user()->logged_in())
			HTTP::redirect('user/login?url='.urlencode(ltrim($info['path'], '/')));
	}
}
