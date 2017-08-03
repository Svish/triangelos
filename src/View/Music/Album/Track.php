<?php
namespace View\Music\Album;

use Model;

/**
 * View: music/album/<id>
 */
class Track extends \View\Layout
{
	public function __construct(string $id)
	{
		$this->id = $id;
		parent::__construct();
	}


	public function track(): \Data\Track
	{
		try
		{
			return Model::music()->track($this->id);
		}
		catch(\Error\PleaseNo $e)
		{
			throw new \Error\NotFound($this->id, 'album track', $e);
		}
	}
}
