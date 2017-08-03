<?php
namespace Controller\Music;

use View\Music\Album as View;


/**
 * Controller: music/album/<year>/<title>
 */
class Album extends \Controller
{
	public function get(int $id, string $slug)
	{
		return (new View("$id/$slug"))
			->output();
	}
}
