<?php

namespace Controller\User;

use Controller\Page, View, Model;
use HTTP, Message;


/**
 * Controller: user/login?url={{PATH|urlencode}}
 *  *
 * TODO: (?) http://stackoverflow.com/a/2093333/39321
 */
class Login extends Page
{
	const FALLBACK = 'user/area';


	public function __construct()
	{
		$_POST['url'] = $_GET['url'] ?? self::FALLBACK;
	}
	

	public function post()
	{
		try
		{
			// Try login
			try
			{
				Model::users()->login($_POST);
				Message::ok('logged-in');
			}
			catch(\Error\NotFound $e)
			{
				throw new \Error\UnknownLogin($e);
			}

			// Redirect, but only if local
			$url = $_POST['url'] ?? self::FALLBACK;
			if(HTTP::is_local($url))
				HTTP::redirect($url, 303);
			else
				HTTP::redirect(self::FALLBACK, 303);
		}
		catch(\Error\User $e)
		{
			return Page::error($e);
		}
	}

}
