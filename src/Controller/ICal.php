<?php

/**
 * Calendar serving.
 */
class Controller_ICal extends Controller
{
	public function get()
	{
		header('content-type: text/calendar');
		echo Model::get('calendar')->ical();
	}
}
