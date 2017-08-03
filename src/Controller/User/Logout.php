<?php

namespace Controller\User;
use HTTP, Model, Message;

/**
 * Controller: user/logout
 */
class Logout extends \Controller
{
	public function get()
	{
		Model::users()->logout();
		Message::ok('logged-out');
		HTTP::redirect();
	}
}
