<?php

namespace View\Helper;

use Mustache_LambdaHelper as Helper;
use DateInterval;
use Log;


/**
 * Helper: Duration
 * 
 * Formats durations.
 */
class Duration
{
	public function __invoke($time, Helper $render = null)
	{
		$time = $render ? $render($time) : $time;

		if($time[0] == 'P')
			return $this->interval($time);

		if(is_numeric($time))
			return $this->number($time);

		return $this->string($time);
	}


	private function string(string $time)
	{
		return ltrim($time, '0:');
	}


	private function number(float $time)
	{
		$h = floor($time / 3600);
		$m = floor($time / 60 % 60);
		$s = floor($time % 60);
		$text = sprintf('%02d:%02d:%02d', $h, $m, $s);
		
		return $this->string($text);
	}


	private function interval(string $time)
	{
		$d = new DateInterval($time);
		$text = $d->format('%h:%I:%S');

		return $this->string($text);
	}
}
