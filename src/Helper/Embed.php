<?php


/**
 * Embed.
 */
class Helper_Embed
{
	const TTL = 14400; // 4 hours
	private $cache;

	public function __construct()
	{
		$this->cache = new Cache(__CLASS__, self::TTL);
	}

	public function __invoke($url)
	{
		return $this->cache->get($url, function($url)
			{
				return $this->fetch($url);
			}, true);
	}

	private function fetch($url)
	{
		$url = urlencode($url);
		$url = "http://www.youtube.com/oembed?url=$url&format=json";
		$json = file_get_contents($url);
		$json = json_decode($json);
		return $json->html;
	}
}
