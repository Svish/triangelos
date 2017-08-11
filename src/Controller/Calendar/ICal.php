<?php

namespace Controller\Calendar;

use Model;


/**
 * Raw ICal Calendar serving.
 */
class ICal extends \Controller
{
	public function get()
	{
		$type = $_GET['type'] ?? 'calendar';
		if( ! in_array($type, ['calendar', 'plain']))
			throw new \Error\PleaseNo('Invalid type');

		header("Content-Type: text/$type; charset=utf-8");
		
		echo Model::calendar()->raw();
	}
}
