<?php

/**
 * Serve thumbnails of images.
 */
class Controller_Thumbnail extends CachedController
{
	protected $max_age = 172800; // 48 hours


	protected $parameter_whitelist = ['q'];

	private $whitelist = [
		[350,150], // Members: Listing
		[350,250], // Members: Details
		[700,700], // Choir: Large image
		[250,250], // Music: Listing, cover
		[320,370], // Music: Album, cover and inlay
		[960,960], // Header
		];
	private $file;



	public function before(array &$info)
	{
		$this->file = $this->find_file($info['params'][3]) ?: DOCROOT.'_/blank.png';

		if( ! $this->file)
			throw new HTTP_Exception("Image not found", 404);

		parent::before($info);
	
	}

	
	protected function cache_valid($cached_time)
	{
		return parent::cache_valid($cached_time)
		   and $cached_time >= filemtime($this->file);
	}

	public function get($w, $h, $path)
	{
		if( ! in_array([$w, $h], $this->whitelist))
			throw new HTTP_Exception('Requested size not in whitelist', 400);

		ini_set('memory_limit','256M');


		$i = new PHPImage($this->file);
		$i->resize((int)$w, (int)$h, false, true);
		$i->setOutput('jpg', 75);
		$i->show();
	}



	private function find_file($path)
	{
		$files = glob(DOCROOT."{_,data}/$path", GLOB_BRACE);
		foreach($files as $file)
			return $file;
	}
}