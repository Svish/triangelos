<?php

/**
 * Base class for data objects based on JSON files.
 */
abstract class JsonData extends Data implements JsonSerializable
{
	const EXT = '.json';

	public static function index()
	{
		foreach(glob(self::path('*')) as $path)
			yield pathinfo($path, PATHINFO_FILENAME);
	}


	/**
	 * Helper: Return absolute path to $id.
	 */
	protected static function path($id)
	{
		return parent::DIR.static::DIR.$id.static::EXT;
	}



	public function __construct($id)
	{
		if(file_exists(self::path($id)))
		{
			$json = File::get(self::path($id));
			$this->data = json_decode($json, true);
		}
	}

	public function save()
	{
		File::put(self::path($this->id), json_encode($this, JSON_PRETTY_PRINT));
		return $this;
	}



	const SERIALIZE = [];
	public function jsonSerialize()
	{
		return empty(static::SERIALIZE)
			? $this->data
			: Util::array_whitelist($this->data, static::SERIALIZE);
	}
}
