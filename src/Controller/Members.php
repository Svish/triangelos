<?php

/**
 * Page for member.
 */
class Controller_Members extends Controller_Page
{
	public function get($id, $context = [])
	{
		$x = Model::members()->get($id, 'id');

		if( ! $x)
			throw new HTTP_Exception('Not found', 404);

		parent::get('member', ['member' => $x]);
	}
}
