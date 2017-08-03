<?php

namespace Controller\Contact;

use View, Message;
use Valid, Email as Send;
use HTTP;

/**
 * Handles sending of contact emails.
 */
class Email extends \Controller\Page
{
	private $_rules = [
		'from' => ['not_empty', 'email', 'email_domain'],
		'subject' => ['not_empty'],
		'message' => ['not_empty'],
		];
	

	public function get()
	{
		if(isset($_GET['sent']))
			Message::ok('email-sent');

		return View::layout()->output();;
	}


	public function post()
	{
		try
		{
			// Check
			Valid::check_array($_POST, $this->_rules);

			// Send
			Send::feedback($_POST['from'], $_POST['subject'], $_POST['message']);
			
			// Redirect
			HTTP::redirect_self();
		}
		catch(\Error\ValidationFailed $e)
		{
			return parent::error($e);
		}
	}
}
