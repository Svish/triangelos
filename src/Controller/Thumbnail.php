<?php

/**
 * Serve thumbnails of images.
 */
class Controller_Thumbnail extends CachedController
{
	protected $parameter_whitelist = ['w', 'h'];

	private $whitelist = [[350,150]];
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

		$i = new PHPImage($this->file);
		$i->setOutput('png', 9);
		$i->resize($w, $h, false, true);
		$i->show();
	}



	private function find_file($name)
	{
		$files = glob(DOCROOT.'{_,data/users}/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
		foreach($files as $file)
			if($name == pathinfo($file, PATHINFO_FILENAME))
				return $file;
	}
}