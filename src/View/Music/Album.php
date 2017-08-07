<?php
namespace View\Music;

use I18N;
use Model;
use Mustache\IteratorPresenter as Presenter;


/**
 * View: music/album/<id>
 */
class Album extends \View\Layout
{
	public $album;

	public function __construct(string $id)
	{
		$this->id = $id;
		$this->album = Model::music()->get($id);
		$this->album->choir = new Presenter($this->album->choir, true);
		$this->album->credits = new Presenter($this->album->credits ?: [], true);

		$this->__ = function(string $s)
			{
				return $s === 'Unknown' ? I18N::translate($s) : $s;
			};

		parent::__construct();
	}

	public function trackCount()
	{
		return count($this->album->tracks);
	}

	public function totalTime()
	{
		$time = 0;
		foreach($this->album->tracks as $track)
			$time += $track->duration['number'];

		return $time;
	}

}
