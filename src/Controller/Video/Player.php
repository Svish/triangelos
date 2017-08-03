<?php
namespace Controller\Video;

use View\Video\Player as View;


/**
 * Controller: video/<id>
 */
class Player extends \Controller
{
	public function get(string $id)
	{
		return (new View($id))
			->output();
	}
}
