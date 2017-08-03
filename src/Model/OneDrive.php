<?php
namespace Model;

use Cache;


/**
 * Stuff from OneDrive.
 *
 * @see https://dev.onedrive.com/
 */
class OneDrive extends \Model
{
	private $config;
	public function __construct()
	{
		$this->config = (object) Config::oneDrive();
	}


	/**
	 * Fetch all items.
	 */
	public function all()
	{
		$cache = new Cache(__CLASS__, true);
		$items =  $cache->get(__METHOD__, function()
		{
			return iterator_to_array($this->_all());
		});

		return $items;
	}



	/**
	 * Fetch all videos from channel.
	 */
	public function _all()
	{
		// Get playlist
		$items = $this->_api('?', [
				'expand' => 'children',
			])->items;

		return $items;
	}



	/**
	 * Helper: Calls the api and returns the decoded json.
	 */
	private function _api($api, array $props)
	{
		$url = "https://api.onedrive.com/v1.0/$api?"
			. http_build_query($props); // + ['key' => $this->config->api_key]);
		$json = file_get_contents($url);
		echo $json.PHP_EOL.PHP_EOL;
		return json_decode($json);
	}
	

	private function base64url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
}

/*

http://stackoverflow.com/a/40471699/39321


GET /shares/{sharingTokenOrUrl}/root?expand=children



$url = 'https://onedrive.live.com/?resid=4A7C4549B6307161!210779&authkey=!ALxY1OeaHKZpzYQ';
$url = 'u!'.base64_encode($url);
$url = urlencode($url);


$url = "https://api.onedrive.com/v1.0/shares/$url/root";
//header('content-type: text/plain');
echo file_get_contents($url);


*/
