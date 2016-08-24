<?php

/**
 * Raw ICal Calendar serving.
 */
class Controller_ICal extends Controller
{
	public function get()
	{
		if( isset($_GET['type']))
			header("content-type: text/{$_GET['type']}; charset=utf-8");
		else	
			header('content-type: text/calendar; charset=utf-8');
			
		echo Model::calendar()->ical();
	}
}
