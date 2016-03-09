<?php

/**
 * Generates images for PayPal pages.
 */
class Controller_PayPalImage extends CachedController
{
	protected $max_age = 172800; // 48 hours

	public function get($id)
	{
		set_time_limit(60);
		ini_set('memory_limit','256M');
		ini_set('gd.jpeg_ignore_warning', '1');

		// Size
		switch($id)
		{
			case 'image':	$w = 150; $h = 50; break;
			case 'logo':	$w = 190; $h = 60; break;
			case 'header':	$w = 750; $h = 90; break;
		}

		// Settings
		$color = (object)[
			'background' => Util::hex2rgb('#FFF'),
			     'title' => Util::hex2rgb('#58129F'),
		];
		$font = (object)[
			     'title' => __DIR__.'/../_fonts/tangerine/Tangerine_Bold.ttf',
		];

		// Create image
		$image = new PHPImage($w, $h);

		// Background
		{
			$image->rectangle(0, 0, $image->getWidth(), $image->getHeight(), $color->background);
		}

		// Title
		{	
			$title = 'Triangelos';

			$image->setFont($font->title);
			$image->setTextColor($color->title);
			$image->textBox($title, [
				'fontFile' => $font->title,
				'fontColor' => $color->title,
				'fontSize' => 120,
				'x' => 0,
				'y' => 0,
				'width' => $image->getWidth(),
				'height' => $image->getHeight(),
			]);
		}

		// Output
		$image->setOutput('png', 9);
		$image->show();
	}
}
