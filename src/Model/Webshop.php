<?php
namespace Model;

use Config;


/**
 * Webshop model.
 *
 * @see https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HH0D0TA
 */
class Webshop extends \Model
{
	private $config;
	public function __construct()
	{
		$this->config = Config::webshop();

		// Localize currency_code
		if(is_array($this->config->add['currency_code']))
			self::localize($this->config->add['currency_code']);

		// Go through each item
		foreach($this->config->items as &$items)
			foreach($items as &$item)
			{
				// Localize item name and amount
				$item['item_name'] = __($item['item_name']);
				if(is_array($item['amount']))
					self::localize($item['amount']);

				// Merge with defaults
				$item += $this->config->add + $this->config->all;
				
				// Create PayPal URL
				$params = array_blacklist($item, ['type']);
				$item['url'] = $this->build_url($params);
			}
	}


	public function display_cart_url()
	{
		$params = $this->config->display + $this->config->all;
		return $this->build_url($params);
	}


	public function items($id)
	{
		return isset($this->config->items[$id])
			? $this->config->items[$id]
			: [];
	}


	private function build_url(array $params)
	{
		return $this->config->url
			. '?'
			. http_build_query($params, null, '&', PHP_QUERY_RFC3986);
	}


	/**
	 * Replace $arr with $arr[LANG] if it exists, otherwise $arr[0].
	 */
	private static function localize(array &$arr)
	{
		$arr = isset($arr[LANG]) ? $arr[LANG] : $arr[0];
	}
}
