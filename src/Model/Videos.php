<?php


/**
 * Videos via YouTube channel.
 *
 * @see https://developers.google.com/youtube/v3/docs/
 */
class Model_Videos extends Model
{
	private $config;
	public function __construct()
	{
		$this->config = (object) Config::youtube();
	}


	/**
	 * Find single video.
	 */
	public function get($id)
	{
		foreach($this->all() as $video)
			if($video['id'] == $id)
				return $video;
	}


	/**
	 * Fetch all videos from channel.
	 */
	public function all()
	{
		$cache = new Cache(__CLASS__, false, true);
		$cache->validate(__METHOD__, filemtime(__FILE__));
		$items =  $cache->get(__METHOD__, function()
		{
			return iterator_to_array($this->_all());
		}, true);

		return $items;
	}



	/**
	 * Fetch all videos from channel.
	 */
	private function _all()
	{
		// Get playlist
		$items = $this->_api('playlistItems', [
				'part' => 'contentDetails',
				'playlistId' => $this->config->channel_playlist_id,
			])->items;

		// Collect video ids
		foreach($items as &$item)
			$item = $item->contentDetails->videoId;

		// Get video details
		$items = $this->_api('videos', [
				'part' => 'snippet,contentDetails,player',
				'maxResults' => 50,
				'hl' => LOCALE,
				'id' => implode(',', $items),
			])->items;

		// Yield what we need
		foreach($items as $video)
		{
			$q = http_build_query([
				'autohide' => 1,
				//'autoplay' => 1,
				'hl' => LOCALE,
				'rel' => 0,
				'showInfo' => 0,
				]);

			$player = $video->player->embedHtml;
			$player = str_replace($video->id, $video->id.'?'.$q, $player);

			yield [
				'title' => $video->snippet->localized->title,
				'published' => $video->snippet->publishedAt,
				'id' => $video->id,
				'duration' => $video->contentDetails->duration,
				'thumbnail' => [
					'url' => $video->snippet->thumbnails->medium->url,
					'width' => $video->snippet->thumbnails->medium->width,
					'height' => $video->snippet->thumbnails->medium->height,
				],
				'player' => $player,
			];
		}
	}



	/**
	 * Helper: Calls the api and returns the decoded json.
	 */
	private function _api($api, array $props)
	{
		$url = "https://www.googleapis.com/youtube/v3/$api?"
			. http_build_query($props + ['key' => $this->config->api_key]);
		$json = file_get_contents($url);
		return json_decode($json);
	}
}
