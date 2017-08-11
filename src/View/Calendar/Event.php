<?php
namespace View\Calendar;

use Config;
use Model;
use Error\NotFound;


/**
 * View: calendar/event/<id>
 */
class Event extends \View\Layout
{
	public $event;

	public function __construct(string $id)
	{
		foreach(Model::calendar()->events() as $e)
			if($e['uid'] === $id)
			{
				$this->event = $e;
				return parent::__construct();
			}

		throw new NotFound($id, 'event');
	}

	public function google()
	{
		return Config::google();
	}
}
