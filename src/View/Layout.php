<?php
namespace View;
use Config, Model, View;

/**
 * View: Mustache layout
 * 
 * Mustache views with common context.
 */
class Layout extends Mustache
{
	public function trail(): iterable
	{
		yield ['.'];
	}

	public function __construct(array $context = [], string $t = null)
	{
		if( ! $t && self::class != static::class)
		{
			$t = starts_with('View\\', static::class)
				? substr(static::class, 5)
				: static::class;
			$t = strtolower($t);
			$t = str_replace('\\', '/', $t);
		}

		$context += [
			'_user' => Model::users()->logged_in(),
			
			'_post' => $_POST,
			'_get' => $_GET,
			
			'_css' => Config::css()[0],
			'_js' => [
				'first' => Config::js()[0],
				'defer' => Config::js()['defer'],
				],

			'_icp' => new Helper\IsCurrentPath,
			'_icl' => new Helper\IsCurrentLanguage,
			'_pc' => new Helper\PathClasses,
			'_tt' => new Helper\TitleTrim,
			'_s' => new Helper\Security,

			'_test_hosts' => json_encode(Config::hosts()['test'] ?? []),

			'_url' => new Helper\Url,
			'_' => new Helper\I18N,
			'messages' => new Helper\Messages,
			'clicky' => new Helper\Clicky,
		];

		parent::__construct($context, $t);
	}
}
