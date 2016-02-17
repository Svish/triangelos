<?php

/**
 * Serve audio files.
 */
class Controller_Audio extends Controller
{
	public function get($url)
	{
		$music = new Model_Music();
		$track = $music->find_by_url($url);
		$name = "{$track->artist} - {$track->album} - {$track->track} - {$track->title}.{$track->ext}";

		Download::send($track->path, ['filename' => $name, 'mime' => $track->mime]);
	}
}