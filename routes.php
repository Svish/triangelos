<?php

return [
	
	# Resources
	'/_/:alpha:.js' => 'Controller_Javascript',
	'/_/:alpha:.css' => 'Controller_Less',
	
	# Media
	'/t/:number:x:number:/:any:' => 'Controller_Thumbnail',

	# PayPal
	'/_/paypal/:alpha:' => 'Controller_PayPalImage',
	'/music/(return)' => 'Controller_PayPalReturn',

	# Members
	'/members/:any:' => 'Controller_Members',

	# User in/out
	'/user/(login|logout|reset)' => 'Controller_User',

	# Tools
	'/tools' => 'Controller_Tools',
	'/tools/:alpha:' => 'Controller_Tools_$1',

	# Contact
	'/(contact/email)' => 'Controller_Email',

	# Music
	'/music/album/:number:/:number:\\.mp3' => 'Controller_AlbumTrack',
	'/music/album/:number:' => 'Controller_Album',


	# Video
	'/video/:alpha:' => 'Controller_Video',

	# Calendar
	'/calendar\.ics' => 'Controller_ICal',

	# API
	'/api/:alpha:/:any:' => 'Controller_Api_$1',

	# Other
	0 => 'Controller_Page',
];
