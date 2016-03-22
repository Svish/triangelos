<?php

use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Webuni\CommonMark\TableExtension\TableExtension;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;

/**
 * Markdown helper.
 *
 * @see http://commonmark.thephpleague.com
 */
class Markdown
{
	private static $c;
	public static function render($markdown)
	{
		if( ! self::$c)
		{
			$e = Environment::createCommonMarkEnvironment();
			$e->addExtension(new AttributesExtension());
			$e->addExtension(new TableExtension());
			//$e->mergeConfig([]);

			self::$c = new Converter(new DocParser($e), new HtmlRenderer($e));
		}

		return self::$c->convertToHtml($markdown);
	}
}
