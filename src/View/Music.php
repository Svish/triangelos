<?php
namespace View;
use Model;

/**
 * View: music
 */
class Music extends \View\Layout
{
	public function albums()
	{
		return Model::music()->all();
	}
}
