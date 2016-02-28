<?php

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
