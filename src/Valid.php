<?php


/**
 * Validator.
 */
class Valid extends Translator
{
	public static function check($subject, array $rules)
	{
		if(is_object($subject))
			$subject = (array) $subject;

		$result = [];
		foreach($rules as $key => $rule)
		foreach($rule as $func)
		{
			if( ! call_user_func_array('self::'.$func, [$subject[$key]]))
			{
				$result[$key][$func] = Translator::translate('error|'.$func);
				break;
			}
		}
		return empty($result) ? true : $result;
	}



	public static function not_empty($value)
	{
		return ! in_array($value, [null, false, '', []], true);
	}

	public static function email($email)
	{
		return Swift_Validate::email($email);
	}

	public static function email_domain($email)
	{
		if ( ! Valid::not_empty($email))
			return FALSE; // Empty fields cause issues with checkdnsrr()

		// Check if the email domain has a valid MX record
		return (bool) checkdnsrr(preg_replace('/^[^@]++@/', '', $email), 'MX');
	}
}
