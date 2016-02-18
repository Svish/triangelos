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
	'/(album/:number:)' => 'Controller_Album',

	// General Pages
	0 => 'Controller_Page',
];
