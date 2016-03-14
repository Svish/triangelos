<?php

/**
 * Handles login/logout.
 */
class Controller_Login extends Controller_Page
{
	
	public function get($url, $context = [])
	{
		if($url == 'logout')
		{
			Model::user()->logout();
			HTTP::redirect();
		}

		return parent::get($url, $context);
	}


	public function post($url)
	{
		if(Model::user()->login($_POST))
			HTTP::redirect('admin');

		HTTP::set_status(422);
		return parent::get($url, Msg::error('error/invalid_login'));
	}

}
