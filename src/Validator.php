<?php


/**
 * Validator.
 */
class Validator
{
	public function __invoke($obj, $rules)
	{

	}


	public static function not_empty($value)
	{
		return ! in_array($value, [null, false, '', []], true);
	}

	public static function email_domain($email)
	{
		if ( ! Valid::not_empty($email))
			return FALSE; // Empty fields cause issues with checkdnsrr()

		// Check if the email domain has a valid MX record
		return (bool) checkdnsrr(preg_replace('/^[^@]++@/', '', $email), 'MX');
	}
}
