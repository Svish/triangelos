<?php
namespace Controller\Music\Album;

use View\Music\Album\Track as View;
use Data\Track as Mp3;


/**
 * Controller: music/album/<year>/<title>/<track>
 */
class Track extends \Controller
{
	public function get(int $id, string $slug, string $n, string $ext = null)
	{
		if($ext == Mp3::EXT)
		{
			var_dump(get_defined_vars());
			exit;
		}
		
		return (new View("$id/$slug/$n"))
			->output();
	}

	// TODO
	private function stream($id, $track)
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
