<?php

namespace Controller\Music\Album;


/**
 * Controller: i/<w>x<h>/album/<year>/<title>/<type>
 * 
 *  - Serves cover and inlay images for music albums.
 * 
 */
class Image extends \Controller\Image
{
	const DIR = 'data/music/';

	protected $whitelist = [
		[0, 0], // original size
		[100,150], // index.ms: Cover
		[120,250], // music.ms: Cover
		[400,500], // music.ms: Cover + inlay
		];

	public function before(array &$info)
	{
		$p = &$info['params'];
		$p[3] = "{$p[3]}/{$p[4]}/{$p[5]}";

		parent::before($info);
	}
}
