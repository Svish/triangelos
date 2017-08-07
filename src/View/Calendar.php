<?php
namespace View;

use Model;


/**
 * View: calendar
 */
class Calendar extends \View\Layout
{
	public function calendar()
	{
		return Model::calendar()->calendar();
	}
}
