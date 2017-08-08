<?php

namespace View;
use Config;


/**
 * View: contact
 */
class Contact extends \View\Layout
{
	public $errors = false;

	public function post()
	{
		return Config::{"contact.post"}();
	}

	public function bank()
	{
		return Config::{"contact.bank"}();
	}

	public function practice()
	{
		return Config::contact()['practice'];
	}

	public function google()
	{
		return Config::google();
	}
}
