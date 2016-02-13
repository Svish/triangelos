<?php

class Mustache
{
	public static function engine()
	{
		return new Mustache_Engine([
			'cache' => CACHE.'mustache',
			'loader' => new Mustache_Loader_CascadingLoader([
				new Mustache_Loader_FilesystemLoader(CONTENT),
				new Mustache_Loader_FilesystemLoader(CONTENT.'..'),
				]),
			'helpers' => [
				'_' => Translator::instance(),
				'url' => new Url(),
				'isProd' => ENV == 'prod',
				'svg' => function($name) { return file_get_contents(DOCROOT.'_'.DIRECTORY_SEPARATOR.$name.'.svg'); },
				],
			]);
	}
}
