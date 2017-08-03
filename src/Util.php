<?php

class Util
{


	/**
	 * Yields the sub paths of $url.
	 *
	 * false => a/b/c, a/b, a
	 * true  => a/b/c, b/c, c
	 */
	public static function sub_paths($url, $backwards = false)
	{
		$url = explode('/', $url);
		while( ! empty($url))
		{
			yield implode('/', $url);
			if($backwards)
				array_shift($url);
			else
				array_pop($url);
		}
	}



	/**
	 * @see https://github.com/kohana/core/blob/3.3/master/classes/Kohana/Arr.php#L437
	 */
	public static function merge($array1, $array2)
	{
		foreach ($array2 as $key => $value)
		{
			if (is_array($value)
			AND isset($array1[$key])
			AND is_array($array1[$key]) )
			{
				$array1[$key] = Util::merge($array1[$key], $value);
			}
			else
			{
				$array1[$key] = $value;
			}
		}

		return $array1;
	}
}
