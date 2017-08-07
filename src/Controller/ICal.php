<?php

namespace Controller;

use Model;


/**
 * Raw ICal Calendar serving.
 */
class ICal extends \Controller
{
	public function get()
	{
		if($_GET['type'] ?? null == 'plain')
			header("content-type: text/{$_GET['type']}; charset=utf-8");
		else	
			header('content-type: text/calendar; charset=utf-8');
			
		echo Model::calendar()->ical();
	}
}
