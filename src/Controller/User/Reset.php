<?php

namespace Controller\User;

use HTTP, Model, View, Email, Message;
use Controller\Page;


/**
 * Controller: user/reset
 */
class Reset extends Page
{
	public function get()
	{
		if(isset($_GET['token']))
		{
			try
			{
				Model::users()->login_token($_GET);
				Message::ok('reset-done');
				HTTP::redirect('user/me', 303);
			}
			catch(\Error\UnknownResetToken $e)
			{
				return Page::error($e);
			}
		}

		return View::layout()->output();
	}


	public function post()
	{
		// Look for user
		try
		{
			try
			{
				$user = Model::users()->get($_POST['email']);
			}
			catch(\Error\NotFound $e)
			{
				throw new \Error\UnknownLogin($e);
			}
		}
		catch(\Error\UnknownLogin $e)
		{
			return Page::error($e);
		}

		// Send email
		Email::reset($user);
		Message::ok('reset-sent');
		HTTP::redirect_self();
	}
}
