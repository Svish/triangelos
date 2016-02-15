<?php

/**
 * Pages.
 */
class Controller_Email extends Controller_Page
{
	private $rules = [
		'from' => ['not_empty', 'email', 'email_domain'],
		'subject' => ['not_empty'],
		'message' => ['not_empty'],
		];

	private $config;

	public function __construct()
	{
		$this->config = parse_ini_file(CONFIG.'.contact.ini', true, INI_SCANNER_RAW);
	}


	public function post($url)
	{
		// Validate
		$result = Valid::check($_POST, $this->rules);
		if($result !== true)
		{
			HTTP::set_status(400);
			return $this->get($url, ['errors' => array_map('array_values', $result)]);
		}
			

		extract($_POST, EXTR_SKIP);

		// Create the message
		$message = Swift_Message::newInstance()
			->setFrom($from)
			->setReplyTo($this->config['email']['address'])
			->setTo([$this->config['email']['address'] => $this->config['email']['name']])
			->setSubject($subject)
			->setBody($message);


		// Create transport
		$transport = Swift_SmtpTransport::newInstance()
			->setHost($this->config['email']['server'])
			->setPort($this->config['email']['port'])
			->setEncryption('tls')
			->setUsername($this->config['email']['username'])
			->setPassword($this->config['email']['password']);

		// Send the message
		$mailer = Swift_Mailer::newInstance($transport);
		if($mailer->send($message))
			HTTP::redirect($url.'?sent=true');

		throw new HTTP_Exception('Failed to send email', 500);
	}
}
