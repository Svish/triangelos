<?php

/**
 * Calendar serving.
 */
class Controller_Calendar extends Controller
{
	public function get()
	{
		header('content-type:text/plain');
		echo Model::get('calendar')->ical();
	}
}