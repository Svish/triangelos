<?php

/**
 * Send a download to the browser.
 */
class Stream
{
	/**
	 * Send a file to the client.
	 *
	 * @see http://www.media-division.com/the-right-way-to-handle-file-downloads-in-php
	 * @see http://stackoverflow.com/a/7591130/39321
	 */
	public static function send($path, $options)
	{
		$options = $options += [
			'mime' => 'application/octet-stream',
			'download' => false,
			'filename' => basename($path),
			];


		// Check file exists
		if( ! is_file($path) || ! is_readable($path))
			self::exit_status(404);

		// Make sure there's no buffering going on
		while (ob_get_level() > 0)
			ob_end_clean();

		// Close session if any
		if(session_name())
			session_write_close();

		// Disable time limit of script (hopefully)
		set_time_limit(0);


		// Parse requested range(s)		
		$size = filesize($path);
		$ranges = array_key_exists('HTTP_RANGE', $_SERVER) ? $_SERVER['HTTP_RANGE'] : '0-';
		$ranges = self::parse_ranges($ranges, $size);


		// Send headers
		$range_string = implode(',', self::collect($ranges, 0));
		$range_total = array_sum(self::collect($ranges, 3));
		$disposition = $options['download'] ? 'attachment' : 'inline';

		header("Accept-Ranges: bytes");
		header("Content-Range: bytes $range_string/$size");
		
		header("Pragma: public");
		header("Cache-Control: public, no-cache");
		
		header("Content-Type: {$options['mime']}");
		header("Content-Length: $range_total");
		header("Content-Disposition: $disposition; filename=\"{$options['filename']}\"");
		header("Content-Transfer-Encoding: binary");


		// Send file
		$fp = fopen($path, 'rb');
		foreach($ranges as $r)
		{
			fseek($fp, $r[1]);
			while(ftell($fp) < $r[2] && ! feof($fp) && connection_status() === CONNECTION_NORMAL)
			{
				$read = min($r[2]+1-ftell($fp), 8192);
				echo fread($fp, $read);
				flush();
			}
		}
		fclose($fp);
	}



	protected static function parse_ranges($ranges, $size)
	{
		//$ranges = preg_replace('/\s+/g', '', $_SERVER['HTTP_RANGE']);
		preg_match_all('/(\d*)-(\d*)/', $ranges, $ranges, PREG_SET_ORDER);
		foreach($ranges as &$r)
		{
			$r[1] = $r[1] === '' ? null : (int) $r[1];
			$r[2] = $r[2] === '' ? null : (int) $r[2];

			// Empty range is not valid
			if(is_null($r[1]) && is_null($r[2]))
				self::exit_status(416);

			// End if empty
			if(is_null($r[2]))
				$r[2] = $size-1;

			// End not above size
			$r[2] = min($r[2], $size-1);

			// Suffix mode (last n bytes)
			if(is_null($r[1]))
			{
				$r[1] = $size-1-$r[2];
				$r[2] = $size-1;
				$r[3] = $r[2]-$r[1];
			}
			else
				$r[3] = $r[2]-$r[1]+1;

			// Number of bytes <= 0?
			if($r[2]-$r[1]+1 <= 0)
				self::exit_status(416);

			// Update "id"
			$r[0] = $r[1].'-'.$r[2];
		}
		return $ranges;
	}

	protected static function exit_status($status)
	{
		http_response_code($status);
		exit;
	}

	protected static function collect(array $array, $key)
	{
		$items = [];
		foreach($array as $item)
			if(array_key_exists($key, $item))
				$items[] = $item[$key];
		return $items;
	}
}