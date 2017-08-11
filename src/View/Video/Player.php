<?php
namespace View\Video;

use Model;

/**
 * View: video/<id>
 */
class Player extends \View\Video
{
	public function __construct(string $id)
	{
		$this->id = $id;
		parent::__construct();
	}


	public function video()
	{
		return Model::YouTube()->get($this->id);
	}


	public function videos()
	{
		foreach(parent::videos() as $v)
			if($this->id != $v['id'])
				yield $v;
	}
}
