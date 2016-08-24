<?php

/**
 * Video API.
 */
class Controller_Api_Video extends Controller_Api
{
	public function get($id)
	{
		$video = Model::videos()->get($id);
		echo $video['player'];
	}
}
