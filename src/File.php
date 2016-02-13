<?php


/**
 * File helper.
 *
 * @see http://php.net/manual/en/function.fopen.php
 * @see http://php.net/manual/en/function.flock.php
 */
class File
{

	public static function get($filename, $default = NULL)
	{
		$fp = @fopen($filename, 'r');
		if( ! $fp)
			return $default;

		flock($fp, LOCK_SH);
		$contents = fread($fp, filesize($filename));
		flock($fp, LOCK_UN);
		fclose($fp);

		return $contents;
	}


	public static function put($filename, $contents)
	{
		self::check(dirname($filename));

		$fp = fopen($filename, 'c');
		flock($fp, LOCK_EX);
		ftruncate($fp, 0);
		fwrite($fp, $contents);
		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);

		return $contents;
	}



	public static function check($dir)
	{
		if( ! is_dir($dir))
		{
			// https://en.wikipedia.org/wiki/Chmod#System_call
			@mkdir($dir, 06750, true);
			@chmod($dir, 06750);
		}
		return $dir;
	}



	public static function rdelete($directory)
	{
		if( ! is_dir($directory))
			return;

		$it = new RecursiveDirectoryIterator($directory);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

		foreach($it as $file)
			if($file->isDir())
				@rmdir($file->getRealPath());
			else
				@unlink($file->getRealPath());
	}
}
