<?php

class Msg
{
	public static function ok($text)
	{
		return self::get('ok', $text);
	}

	public static function error($text)
	{
		return self::get('error', $text);
	}

	public static function get($type, $text)
	{
		return ['message' => get_defined_vars()];
	}
}
