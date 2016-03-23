<?php

return [
	
	# Resources
	'/_/:alpha:.js' => 'Controller_Javascript',
	'/_/:alpha:.css' => 'Controller_Less',
	
	# Media
	'/t/:number:x:number:/:any:' => 'Controller_Thumbnail',
	'/stream/:any:' => 'Controller_Stream',

	# PayPal
	'/_/paypal/:alpha:' => 'Controller_PayPalImage',
	'/music/(return)' => 'Controller_PayPalReturn',

	# Member area
	'/(member-area/(login|logout|reset))' => 'Controller_Login',
	'/(member-area(?:/.+)?)' => 'Controller_MemberArea',

	# Contact
	'/(contact/email)' => 'Controller_Email',

	# Music
	'/music/(album/:number:)' => 'Controller_Album',

	# Calendar
	'/calendar\.ics' => 'Controller_ICal',

	# Other
	0 => 'Controller_Page',
];
