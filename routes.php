<?php

return [
	
	// Resources
	'/_/:alpha:.js' => 'Controller_Javascript',
	'/_/:alpha:.css' => 'Controller_Less',
	
	// Media
	'/t/:number:x:number:/:any:' => 'Controller_Thumbnail',
	'/stream/:any:' => 'Controller_Stream',

	// PayPal
	'/_/paypal/:alpha:' => 'Controller_PayPalImage',
	'/music/(return)' => 'Controller_PayPalReturn',

	// Special Pages
	'/(contact/email)' => 'Controller_Email',
	'/(user/(login|logout|reset))' => 'Controller_Login',
	'/music/(album/:number:)' => 'Controller_Album',
	'/calendar\.ics' => 'Controller_ICal',

	// Admin pages
	'/(dashboard(?:/.+)?)' => 'Controller_Dashboard',

	// General Pages
	0 => 'Controller_Page',
];
