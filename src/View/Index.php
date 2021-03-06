<?php

namespace View;

use Model;


/**
 * View: index
 */
class Index extends \View\Layout
{
	public function __construct()
	{		
		parent::__construct();
	}


	public function albums()
	{
		$n = 0;
		foreach(Model::music()->all() as $album)
		{
			if(++$n > 2)
				break;
			else
				yield $album;
		}
	}


	public function events()
	{
		return Model::calendar()->upcoming(2);
	}


	public function facebook()
	{
		return Model::facebook()->latest();
	}
}
