<?php
namespace View;

use Model;


/**
 * View: video
 */
class Video extends \View\Layout
{
	public function videos()
	{
		return Model::YouTube()->all();
	}

	public function channel()
	{
		return Model::YouTube()->channel();
	}
}
