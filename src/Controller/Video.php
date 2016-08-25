<?php

/**
 * Page for single video.
 */
class Controller_Video extends Controller_Page
{
	public function get($id = null, $context = [])
	{
		$video = Model::youtube()->get($id);
		
		if( ! $video)
			throw new HTTP_Exception('Not found', 404);
		
		parent::get('video/player', ['video' => $video]);
	}
}