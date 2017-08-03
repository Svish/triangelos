<?php

class Msg
{
	
	public static function __callStatic($name, $args)
	{
		$key = array_shift($args);
		return self::get($name, Text::$type($key));
	}

	public static function get($type, $text)
	{
		return ['message' => get_defined_vars()];
	}
}
