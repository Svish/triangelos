<?php

return [
	
	# Resources
	'js/(:any:.js)' => 'Controller\\Javascript',
	'theme/(?::any:\.css)' => 'Controller\\Less',
	'theme/icon/(:any:\.svg)' => 'Controller\\Svg',
	

	# Images
	'i/(?::number:x:number:/)?album/:number:/:alphanum:/:any:' => 'Controller\\Music\\Album\\Image',
	'i/(?::number:x:number:/)?member/:alpha:' => 'Controller\\Member\\Image',
	'i/(?::number:x:number:/)?:any:' => 'Controller\\Image',
	

	# Video
	'video/:alphanum:' => 'Controller\\Video\\Player',


	# Music
	'music/album/:number:/:alphanum:/:number:(\.mp3)?' => 'Controller\\Music\\Album\\Track',
	'music/album/:number:/:alphanum:' => 'Controller\\Music\\Album',


	# Calendar
	'calendar\.ics' => 'Controller\\ICal',


	# PayPal
	'_/paypal/:alpha:' => 'Controller\\PayPal\\Image',
	'music/(return)' => 'Controller\\PayPal\\Return',




	# APIs
	'.+/api/:alpha:' => function (array $request)
	{
		$path = ucwords($request['path'], '/-');
		$path = str_replace('/', '\\', $path);
		$handler = substr($path, 0, strrpos($path, '\\'));
		return "Controller\\$handler";
	},


	# Any other pages
	0 => function (array $request)
	{
		$path = ucwords($request['path'], '/-');
		$path = str_replace(['-', '/'], ['', '\\'], $path);
		$handler = "Controller\\$path";
		return class_exists($handler)
			? $handler
			: 'Controller\\Page';
	},
];
