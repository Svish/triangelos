<?php

namespace Controller;
use Session, PHPImage, Log;
use Error\NotFound;

/**
 * Controller: i/<w>x<h>/<image>
 * 
 *  - Serves resized images.
 */
class Image extends Cached
{
	const DIR = 'data/images/';

	protected $whitelist = [
		[0, 0], // Original size
		[700,700], // choir.ms: Large image
		];
		
	private $file;



	public function before(array &$info)
	{
		Log::trace("Looking for {$info['params'][3]}");
		$this->file = static::find($info['params'][3]);

		// Check size
		$w = $info['params'][1] = (int) $info['params'][1];
		$h = $info['params'][2] = (int) $info['params'][2];
		if( ! in_array([$w, $h], $this->whitelist))
			throw new \Error\PleaseNo('Requested size not in whitelist');

		parent::before($info);
	}


	protected static function find(string $name): string
	{
		$path = static::DIR.$name;
		
		if(file_exists($path))
			return $path;

		foreach(glob("$path.{jpg,png}", GLOB_BRACE) as $file)
			return $file;

		throw new NotFound($name, 'image');
	}

	
	protected function cache_valid($cached_time)
	{
		return parent::cache_valid($cached_time)
		   and $cached_time > filemtime($this->file);
	}

	public function get(int $w, int $h, string $path)
	{
		Log::group();
		Session::close();	

		try
		{
			Log::trace_raw("Reading {$this->file}");
			$i = new PHPImage($this->file);
		}
		catch(\Exception $e)
		{
			throw new NotFound($path, 'image', $e);
		}

		if($w > 0 || $h > 0)
		{
			Log::trace_raw("Resizing to {$w}x{$h}");
			$i->resize((int)$w, (int)$h, false, true);
		}

		Log::trace_raw("Outputting jpg");
		$i->setOutput('jpg', 90);
		$i->show();
		Log::groupEnd();
	}

	use \Candy\WinPathFix;
}
