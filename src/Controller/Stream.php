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


		$path = $track->path;
		$preview = substr_replace($path, '-preview', -4, 0);

		Download::send(file_exists($preview) ? $preview : $path,
			[
				'filename' => $name,
				'mime' => $track->mime,
			]);
	}
}