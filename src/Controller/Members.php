<?php

/**
 * Page for member.
 */
class Controller_Members extends Controller_Page
{
	public function get($id = null, $context = [])
	{
		$x = Model::members()->find($id, 'id');

		if( ! $x)
			throw new HTTP_Exception('Not found', 404);

		parent::get('member', ['member' => $x]);
	}
}
