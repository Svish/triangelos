<?php

return [

	// Scripts to load normally
	0 => [
		'//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',
		'//cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js',
		'js/script.js',
		],

	// Scripts to load deferred
	'defer' => [
		'//cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/jplayer/jquery.jplayer.min.js',
		'js/nav.js',
		],

	// Files to pack together
	'bundles' => [

		'script' => [
			'strict',
			'nprogress',
			'polyfills',
			],

		'nav' => [
			'strict',
			'jquery.ajax-events',
			'nav.link-external',
			'nav.loading',
			'nav.language',
			],

		],
];
