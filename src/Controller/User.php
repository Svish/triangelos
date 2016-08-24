<?php

/**
 * Handles login, logout and resetting of password.
 */
class Controller_User extends Controller_Page
{
	private $rules = [
		'email' => ['not_empty', 'email', 'email_domain'],
		];

	public function before(array &$info)
	{
		$info['method'] = "{$info['params'][1]}_{$info['method']}";
		$info['params'][1] = 'user/'.$info['params'][1];
		parent::before($info);
	}



	/**
	 * Logout
	 */
	public function logout_get($url)
	{
		Model::user()->logout();
		HTTP::redirect();
	}



	/**
	 * Login
	 */
	public function login_post($url)
	{
		if(Model::user()->login($_POST))
		{
			$url = empty($_POST['url'])
				? 'members'
				: $_POST['url'];
			HTTP::redirect($url);
		}

		HTTP::set_status(422);
		return parent::get($url, Msg::error('error/invalid_login'));
	}



	/**
	 * Reset token stuff.
	 */
	public function reset_get($url)
	{
		if(isset($_GET['id']))
		{
			if(Model::user()->token($_GET))
				HTTP::redirect('tools/members/edit/me');
			else
				return parent::get($url, Msg::ok('error/invalid_token'));
		}

		if(isset($_GET['sent']))
		{
			return parent::get($url, Msg::ok('message/reset_sent'));
		}

		return parent::get($url);
	}

	public function reset_post($url)
	{
		// Validate email
		$result = Valid::check($_POST, $this->rules);
		if($result !== true)
		{
			HTTP::set_status(422);
			return $this->get($url, Msg::error('error/reset_fail') + ['errors' => array_map('array_values', $result)]);
		}

		// Look for member
		$this->member = Model::user()->token($_POST);
		if( ! $this->member)
		{
			HTTP::set_status(422);
			return parent::get($url, Msg::error('error/not_a_member'));
		}

		// Create and send email
		$to = [$this->member->email => $this->member->first];
		$subject = ucfirst(HOST).' reset link';
		$message = Mustache::engine()->render('user/reset-email', $this);

		if(Email::info($to, $subject, $message))
			HTTP::redirect('user/reset?sent');
		else
			throw new HTTP_Exception('Failed to send email', 500);
	}

}
