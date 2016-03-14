<?php

/**
 * Admin controller.
 */
class Controller_Admin extends Controller_Page
{
	public function before(array &$info)
	{
		parent::before($info);

		if( ! Model::user()->logged_in())
			HTTP::redirect('login?url='.urlencode(ltrim($info['path'], '/')));
	}

	public function get($url, $context = [])
	{
		parent::get($url, [
			'title' => 'Admin',
			]);
	}
}
