<?php

if( ! in_array($_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1']))
	throw new HTTP_Exception('No access to admin pages until user accounts have been implemented...', 403);

/**
 * Admin controller.
 */
class Controller_Admin extends Controller_Page
{
	public function get($url, $context = [])
	{
		parent::get($url, [
			'title' => 'Admin',
			]);
	}
}
