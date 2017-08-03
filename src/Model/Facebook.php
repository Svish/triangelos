<?php

namespace Model;

use Cache;


/**
 * Stuff from Facebook.
 *
 * @see https://developers.facebook.com/docs/graph-api/using-graph-api/
 * @see https://developers.facebook.com/docs/graph-api/reference/v2.7/post
 * @see https://developers.facebook.com/docs/graph-api/reference/v2.7/page
 * @see https://developers.facebook.com/tools/explorer/307412509315861?method=GET&path=triangelos%2Fposts&version=v2.7
 */
class Facebook extends \Model
{
	private $config;
	public function __construct()
	{
		$this->config = (object) Config::facebook();
	}


	/**
	 * Latest posts from triangelos page
	 */
	public function latest()
	{
		$cache = new Cache(__CLASS__, false, 60*60);
		$items =  $cache->get(__METHOD__, function()
		{
			return iterator_to_array($this->_latest());
		});
		return $items;
	}
	private function _latest()
	{
		// Get video details
		$data = $this->_api('triangelos/posts', [
				'fields' => implode(',', [
					'id',
					'created_time',
					'type',
					'link',
					'full_picture',
					//'picture',
					'message',
					'caption',
					'description',
					]),
				'limit' => 7,
			])->data;

		// Yield!
		foreach($data as $item)
		{
			// If missing link, use id (which fb redirects to item)
			if( ! isset($item->link))
				$item->link = 'https://www.facebook.com/'.$item->id;

			// If full_picture, assign to picture
			if(isset($item->full_picture))
				$item->picture = $item->full_picture;

			// Common-ize stuff
			switch ($item->type)
			{
				case 'status':
				case 'photo':
				case 'video':
					$item->text = $item->message;
					break;

				case 'event':
					$item->text = $item->caption;
					break;
			}

			yield $item;
		}
	}



	/**
	 * Helper: Calls the api and returns the decoded json.
	 */
	private function _api($api, array $props)
	{
		$url = "https://graph.facebook.com/v2.7/$api?"
			.http_build_query($props + ['access_token' => $this->config->access_token]);
		$json = file_get_contents($url);
		return json_decode($json);
	}
}
