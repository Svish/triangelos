<?php


/**
 * URL helper for Mustache templates.
 */
class Url
{
	/**
	 * Returns $url prefixed with WEBBASE, or WEBROOT if starting with /.
	 *
	 * - foo => /base/foo
	 * - /foo => http://host/base/foo
	 */
	public function __invoke($url = null, Mustache_LambdaHelper $helper = null)
	{
		return strpos($url, '/') === 0
			? WEBROOT.ltrim($url, '/')
			: WEBBASE.$url;
	}
}
