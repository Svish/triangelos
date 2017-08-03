<?php

return [

	'date' => [
		'w3c' => DATE_W3C,

		'short' => 'j. F, H:i',
		'full' => 'j. F Y, H:i',

		'time' => 'H:i',

		'month-name' => 'F Y',
		'day' => 'j.',
		'week' => 'W',

		'date' => 'j. F Y',
		'date-day' => 'l j.',
		'date-iso' => 'Y-m-d',
		'date-short' => 'j. F',
	],

	'link' => [
		'need_password' => 'Need a password?',
	],

	'title' => [
		
	],

	'message' => [
		'email_sent' => 'The e-mail is sent! We answer as soon as we can :)',
		'reset_sent' => 'E-mail sent! You should shortly receive an e-mail with a link allowing you to login and choose a password.',
		'cookies' => 'Cookies are used to analyze traffic, and when a member logs in.',
	],
	
	'error' => [
		'invalid_token' => 'Invalid reset token.',
		'invalid_login' => 'Invalid login.',
		'email_fail' => 'Failed to send email. Please check your input.',
		'reset_fail' => 'Invalid email address.',
		'not_a_member' => 'Email not registered to a member.',

		'not_empty' => 'Cannot be empty',
		'email' => 'Invalid email address',
		'email_domain' => 'Invalid email domain',
	],
];
