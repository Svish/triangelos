<?php

return [
	
	'/_/:alpha:.js' => 'Controller_Javascript',
	'/_/:alpha:.css' => 'Controller_Less',
	
	'/t/:number:x:number:/:any:' => 'Controller_Thumbnail',
	'/audio/:any:' => 'Controller_Audio',

	'/(contact/email)' => 'Controller_Email',

	0 => 'Controller_Page',
];
