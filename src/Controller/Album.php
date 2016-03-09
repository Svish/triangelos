<?php

/**
 * Page for single album.
 */
class Controller_Album extends Controller_Page
{
	public function get($url, $context = [])
	{
		$music = new Model_Music();
		$album = $music->album($url);
		
		if( ! $album)
			throw new HTTP_Exception('Not found', 404);

		parent::get($url, ['album' => $album]);
	}
}