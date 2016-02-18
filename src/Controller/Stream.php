<?php

/**
 * Stream audio files.
 */
class Controller_Stream extends Controller
{
	public function get($url)
	{
		$music = new Model_Music();
		$track = $music->track($url);
		$name = "{$track->artist} - {$track->album} - {$track->track} - {$track->title}.{$track->ext}";

		Download::send($track->path, ['filename' => $name, 'mime' => $track->mime]);
	}
}