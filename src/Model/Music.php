<?php


/**
 * Music model.
 */
class Model_Music extends Model
{
	const DIR = 'album';
	const ROOT = parent::DIR.self::DIR;


	public function listing()
	{
		return $this->albums();
	}


	public function latest()
	{
		$count = 2;
		foreach($this->albums() as $album)
			if($count-- > 0)
				yield $album;
			else
				return;
	}



	public function track($url)
	{
		foreach($this->albums() as $album)
		foreach($album->tracks as $track)
			if($track->url == $url)
				return $track;
	}



	public function album($url)
	{
		foreach($this->albums() as $album)
			if($album->url == $url)
				return $album;
	}



	public function albums()
	{
		$cache = new Cache(__CLASS__);
		return $cache->get(__METHOD__, function()
			{
				$x = iterator_to_array($this->_albums());
				usort($x, function($a, $b)
				{
					return -1 * strcmp($a->year, $b->year);
				});
				return $x;
			}, true);
	}
	private function _albums()
	{
		$webshop = Model::webshop();

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

						if(strpos($file->getFilename(), 'preview') !== false)
							continue;

						if( ! isset($album['album']))
							$album += [
								'year' => $id3['comments']['year'][0],
								'album' => $id3['comments']['album'][0],
								'artist' => $id3['comments']['artist'][0],
								'url' => self::url($tracks->getSubPath()),
								'items' => $webshop->items($id3['comments']['year'][0]),
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
