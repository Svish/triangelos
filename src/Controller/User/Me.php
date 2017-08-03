<?php

namespace Controller\User;
use HTTP, Model, View, Message;
use Error\HttpException as Error;
use Controller\Page;
/**
 * Handles user account.
 */
class Me extends Page
{
	protected $required_roles = [];
	
	private $me;

	public function __construct()
	{
		parent::__construct();
		$this->me = Model::users()->logged_in();
	}
	

	public function get()
	{
		return View::layout(['me' => $this->me])
			->output();
	}

	const ALLOW = ['first', 'last', 'email', 'phone', 'password'];

	public function post()
	{
		// Make sure we only get what we allow
		$_POST = array_whitelist($_POST, self::ALLOW);
		if( ! $_POST['password'])
			unset($_POST['password']);

		// Try update user
		try
		{
			$x = $this->me
				->set($_POST)
				->save();
			Message::ok($x ? 'saved' : 'no-changes');
			HTTP::redirect_self();
		}
		catch(Error $e)
		{
			return Page::error($e, ['me' => $this->me]);
		}
	}
}
