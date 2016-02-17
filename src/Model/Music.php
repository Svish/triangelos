<?php


/**
 * Music model.
 */
class Model_Music extends Model
{
	const DIR = 'music';
	const ROOT = parent::DIR.self::DIR;

	

	public function find_by_url($url)
	{
		foreach($this->albums() as $album)
		foreach($album->tracks as $track)
			if($track->url == $url)
				return $track;
	}


	public function albums()
	{
		// TODO: Cache this...

		$getID3 = new getID3;
		$albums = new RecursiveDirectoryIterator(self::ROOT, FilesystemIterator::SKIP_DOTS);
		while($albums->valid())
		{
			$album = [];

			$tracks = $albums->getChildren();
			while($tracks->valid())
			{
				$file = $tracks->current();

				switch($file->getExtension())
				{
					case 'mp3':
						$id3 = $getID3->analyze($file);
						getid3_lib::CopyTagsToComments($id3);

						if( ! isset($album['album']))
							$album += [
								'year' => $id3['comments']['year'][0],
								'album' => $id3['comments']['album'][0],
								'artist' => $id3['comments']['artist'][0],
								];

						$album['tracks'][] = (object) [
							'year' => $id3['comments']['year'][0],
							'album' => $id3['comments']['album'][0],
							'artist' => $id3['comments']['artist'][0],
							
							'track' => (int) $id3['comments']['track_number'][0],
							'title' => $id3['comments']['title'][0],

							'length' => $id3['playtime_seconds'],
							'time' => $id3['playtime_string'],
							
							'path' => $file->getRealPath(),
							'size' => $file->getSize(),

							'url' => self::url($tracks->getSubPathName()),
							'mime' => $id3['mime_type'],
							'ext' => $file->getExtension(),
							];
						break;

					case 'jpg':
						$album[$file->getBasename('.'.$file->getExtension())] = self::url($tracks->getSubPathName());
						break;
				}

				$tracks->next();
			}

			// Album complete
			if( $this->valid($album) )
				yield (object) $album;

			$albums->next();
		}
	}


	private function url($path)
	{
		return self::DIR.'/'.str_replace(DIRECTORY_SEPARATOR, '/', $path);
	}


	private function valid($album)
	{
		if(empty($album))
			return false;

		if( ! isset($album['tracks']) || ! isset($album['album']))
			return false;

		return ! empty($album['tracks']);
	}
}
