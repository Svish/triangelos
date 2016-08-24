<?php

/**
 * Page for single album.
 */
class Controller_Album extends Controller_Page
{
	public function get($id = null, $context = [])
	{
		$music = new Model_Music();
		$album = $music->album($id);

		if( ! $album)
			throw new HTTP_Exception('Not found', 404);

		parent::get('album', ['album' => $album]);
	}
}