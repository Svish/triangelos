<?php

namespace Controller\Music\Album;


/**
 * Controller: i/<w>x<h>/album/<year>/<title>/<type>
 * 
 *  - Cover and inlay images for music albums.
 *  - Photos for album and track descriptions.
 * 
 */
class Image extends \Controller\Image
{
	const DIR = 'data/music/';

	protected $whitelist = [
		[0, 0], // original size
		[100,150], // index.ms: Cover

		[120,250], // music.ms: Cover
		[ 75, 50], // music/album.ms: Tiny cover in .meta
		[400,500], // music/album.ms: Cover + inlay
		];

	public function before(array &$info)
	{
		$p = &$info['params'];
		$p[3] = "{$p[3]}/{$p[4]}/{$p[5]}";

		parent::before($info);
	}
}
