<?php
namespace Controller\Calendar;

use View\Calendar\event as View;


/**
 * Controller: music/album/<year>/<title>
 */
class Event extends \Controller
{
	public function get(string $id)
	{
		$view = new View($id);
		$view->output();
	}
}
