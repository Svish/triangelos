<?php

/**
 * Stream album track.
 */
class Controller_AlbumTrack extends SessionController
{
	private $url;
	public function before(array &$info)
	{
		parent::before($info);
		$this->url = trim($info['path'], '/');
	}


	public function get($id, $track)
	{
		$album = Data::album($id);
		$track = (object) $album->tracks[$track-1];

		// Redirect to preview if not logged in
		if( ! isset($_GET['preview']) && ! Model::user()->logged_in())
			HTTP::redirect($this->url.'?preview', 302);

		// Select path
		$path = isset($_GET['preview']) ? $track->path_preview : $track->path;

		// Stream!
		Stream::send($path,
			[
				'filename' => "{$album->artist} - {$album->title} - {$track->track} - {$track->title}.{$track->ext}",
				'mime' => $track->mime,
			]);
	}
}
