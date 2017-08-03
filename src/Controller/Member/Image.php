<?php

namespace Controller\Member;

use Error\NotFound;


/**
 * Controller: i/<w>x<h>/member/<id>
 * 
 *  - Serves resized member photos.
 * 
 */
class Image extends \Controller\Image
{
	const DIR = 'data/user/';

	protected $whitelist = [
		[450,120], // members.ms: Member photo
	];


	protected static function find(string $name): string
	{
		try
		{
			return parent::find($name);
		}
		catch(NotFound $e)
		{
			return realpath(self::DIR.'_.png');
		}
	}
}
