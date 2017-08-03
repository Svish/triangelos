<?php
namespace View\Music;

use Model;

/**
 * View: music/album/<id>
 */
class Album extends \View\Layout
{
	public function __construct(string $id)
	{
		$this->id = $id;
		parent::__construct();
	}

	private $_album;
	public function album(): \Data\Album
	{
		if( ! $this->_album)
			try
			{
				$this->_album = Model::music()->get($this->id);
				foreach($this->_album->choir ?? [] as $k => $v)
				{
					$choir[] = ['role' => $k, 'members' => $v];
				}
				$this->_album->choir = $choir ?? [];
			}
			catch(\Error\PleaseNo $e)
			{
				throw new \Error\NotFound($this->id, 'album', $e);
			}
		return $this->_album;
	}

	public function trackCount()
	{
		return count($this->album()->tracks);
	}

	public function totalTime()
	{
		$time = 0;
		foreach($this->album()->tracks as $track)
			$time += $track->seconds;

		return $time;
	}

}
