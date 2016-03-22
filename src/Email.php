<?php

/**
 * Email helper.
 */
class Email
{
	/**
	 * Send info $to someone.
	 */
	public function send_info($to, $subject, $message)
	{
		$message = Swift_Message::newInstance()
			->setFrom($this->config['smtp']['username'])
			->setTo($to)
			->setSubject($subject)
			->setBody($message);

		return $this->send($message);
	}


	/**
	 * Send contact email $from someone.
	 */
	public function send_feedback($from, $subject, $message)
	{
		$message = Swift_Message::newInstance()
			->setTo($this->config['contact']['address'])
			->setFrom($from)
			->setSubject($subject)
			->setBody($message);

		return $this->send($message);
	}


	/**
	 * Send message.
	 */
	private function send(Swift_Message $message)
	{
		// Set common message stuff
		$text = $message->getBody();
		$html = Markdown::render($text);
		$message
			->setSender($this->config['smtp']['username'])
			->setBody($html, 'text/html')
			->addPart($text, 'text/plain');

		// Create transport
		$transport = Swift_SmtpTransport::newInstance()
			->setEncryption('tls')
			->setHost($this->config['smtp']['server'])
			->setPort($this->config['smtp']['port'])
			->setUsername($this->config['smtp']['username'])
			->setPassword($this->config['smtp']['password']);

		// Send message
		$mailer = Swift_Mailer::newInstance($transport);
		//$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin(new Swift_Plugins_Loggers_EchoLogger()));$mailer->send($message);exit;
		return $mailer->send($message);
	}


	public static function __callStatic($name, $args)
	{
		$email = new self;
		$email->config = parse_ini_file(CONFIG.'.contact.ini', true, INI_SCANNER_RAW);
		return call_user_func_array([$email, "send_$name"], $args);
	}
}
