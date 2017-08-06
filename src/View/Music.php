<?php
namespace View;
use Model;

/**
 * View: music
 */
class Music extends \View\Layout
{
	public $albums;

	public function __construct()
	{
		$this->albums = Model::music()->all();		
		parent::__construct();
	}
}
