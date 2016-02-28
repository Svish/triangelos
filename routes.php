<?php

return [
	
	// Resources
	'/_/:alpha:.js' => 'Controller_Javascript',
	'/_/:alpha:.css' => 'Controller_Less',
	
	// Media
	'/t/:number:x:number:/:any:' => 'Controller_Thumbnail',
	'/stream/:any:' => 'Controller_Stream',

	// Special Pages
	'/(contact/email)' => 'Controller_Email',
	'/music/(album/:number:)' => 'Controller_Album',
	'/calendar\.ics' => 'Controller_ICal',

	// Admin pages
	'/(admin/:any:)' => 'Controller_Admin',

	// General Pages
	0 => 'Controller_Page',
];
