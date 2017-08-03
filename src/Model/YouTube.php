<?php
namespace Model;

use Cache\I18N as Cache;
use Config;


/**
 * Stuff from the YouTube channel.
 *
 * @see https://developers.google.com/youtube/v3/docs/
 */
class YouTube extends \Model
{
	private $config;
	public function __construct()
	{
		$this->config = (object) Config::youtube(INI_SCANNER_RAW);
	}


	public function channel()
	{
		$channel = $this->_api('channels', [
				'part' => 'statistics',
				'id' => $this->config->channel_id,
			])->items[0]->statistics;

		$channel->id = $this->config->channel_id;
		return $channel;
	}


	/**
	 * Find single video.
	 */
	public function get($id)
	{
		foreach($this->all() as $video)
			if($video['id'] == $id)
				return $video;

		throw new \Error\NotFound($id, 'video');
	}


	/**
	 * Fetch all videos from channel.
	 */
	public function all()
	{
		$cache = new Cache(__CLASS__);
		$items =  $cache->get(__METHOD__, function()
		{
			return iterator_to_array($this->_all());
		});

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
				'hl' => LOCALE,
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
				'enablejsapi' => 1,
				//'autoplay' => 1,
				'hl' => LOCALE,
				'rel' => 0,
				'showInfo' => 0,
				]);

			$player = $video->player->embedHtml;
			$player = str_replace($video->id, $video->id.'?'.$q, $player);

			$title = $video->snippet->localized->title;
			$title = preg_replace($this->config->title_clean, '', $title);

			yield [
				'id' => $video->id,
				'title' => $title,
				'published' => $video->snippet->publishedAt,
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
