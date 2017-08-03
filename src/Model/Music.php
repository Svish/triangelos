<?php
namespace Model;

use Data\Album;
use Data\Track;


/**
 * Music model.
 */
class Music extends \Model
{
	/**
	 * All albums in decreasing order.
	 */
	public function all(): iterable
	{
		return iterable_reverse(Album::all());
	}

	/**
	 * Get single album.
	 */
	public function get(string $id): Album
	{
		return Album::get($id);
	}

	/**
	 * Get single track.
	 */
	public function track(string $id): Track
	{
		return Track::get($id);
	}
}
