<?php

/**
 * Dashboard controller.
 */
class Controller_Dashboard extends Controller_Page
{
	public function before(array &$info)
	{
		parent::before($info);

		if( ! Model::user()->logged_in())
			HTTP::redirect('user/login?url='.urlencode(ltrim($info['path'], '/')));
	}

	public function get($url, $context = [])
	{
		parent::get($url, [
			'title' => 'Dashboard',
			]);
	}
}
