<?php

/**
 * Handles sending of contact emails.
 */
class Controller_Email extends Controller_Page
{
	private $rules = [
		'from' => ['not_empty', 'email', 'email_domain'],
		'subject' => ['not_empty'],
		'message' => ['not_empty'],
		];
	
	
	public function get($url = null, $context = [])
	{
		if(isset($_GET['sent']))
			$context += Msg::ok('message/email_sent');

		parent::get($url, $context);
	}


	public function post($url)
	{
		// Validate
		$result = Valid::check($_POST, $this->rules);
		if($result !== true)
		{
			HTTP::set_status(422);
			$context = Msg::error('error/email_fail') + ['errors' => array_map('array_values', $result)];
			return $this->get($url, $context);
		}
		
		// Send
		$sent = Email::feedback($_POST['from'], $_POST['subject'], $_POST['message']);
		if($sent)
			HTTP::redirect($url.'?sent');
		else
			throw new HTTP_Exception('Failed to send email', 500);
	}
}
