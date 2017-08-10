<?php

namespace View\Helper;
use Mustache_LambdaHelper as LH;
use I18N as I;
use Config;


/**
 * Translation helper for Mustache templates.
 * 
 *     {{text | _}}
 *     {{text | _.category}}
 */
class I18N
{
	private $_category;
	public function __construct(string $category = null)
	{
		if($category)
			$this->_category = "$category/";
	}


	public function __invoke($text, LH $render = null)
	{
		if($render)
			$text = $render($text);

		return I::translate($this->_category.$text);
	}


	/**
	 * For limiting to category.
	 */
	private $_categories;
	public function __get($category)
	{
		return $this->_categories[$category]
			?? $this->_categories[$category] = new self($category);
	}	
	public function __isset($key)
	{
		return true;
	}


	/**
	 * Yield language options.
	 */
	public function options()
	{
		$hosts = Config::hosts();

		// Current host first
		$info = $hosts[HOST];
		$info['host'] = HOST;
		yield $info;

		// Then the rest
		foreach($hosts as $host => $info)
			if($host != HOST && $host != 'test')
			{
				$info['host'] = $host;
				yield $info;
			}
	}
}
