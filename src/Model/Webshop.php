<?php


/**
 * Webshop model.
 *
 * @see https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HH0D0TA
 */
class Model_Webshop extends Model
{
	private $config;

	public function __construct()
	{
		$config = require CONFIG.'.webshop.inc';

		// Localize currency code
		self::localize($config->add['currency_code']);

		foreach($config->items as &$items)
			foreach($items as &$item)
			{
				// Localize item name and amount
				$item['item_name'] = __($item['item_name']);
				self::localize($item['amount']);

				// Merge with defaults for cart add item
				$item += $config->add;
				
				// Create PayPal URL
				$params = Util::array_blacklist($item, ['type']);
				$item['url'] = $config->api.'?'.http_build_query($params, null, '&', PHP_QUERY_RFC3986);
			}

		$this->config = $config;
	}


	public function display_cart_url()
	{
		$params = $this->config->display;
		return $this->config->api.'?'.http_build_query($params, null, '&', PHP_QUERY_RFC3986);
	}


	public function items($album)
	{
		return isset($this->config->items[$album])
			? $this->config->items[$album]
			: [];
	}


	/**
	 * Replace $arr with $arr[LANG] if it exists, otherwise $arr[0].
	 */
	private static function localize(array &$arr)
	{
		$arr = isset($arr[LANG]) ? $arr[LANG] : $arr[0];
	}
}
