<?php


/**
 * Slightly hackish date formatter.
 */
class Helper_Df
{
	private $cache = [];

	public function __get($key)
	{
		return $this->cache[$key];
	}

	public function __isset($key)
	{
		if(array_key_exists($key, $this->cache))
			return true;

		if(method_exists($this, "_$key"))
		{
			$r = new ReflectionMethod($this, "_$key");
			$this->cache[$key] = $r->getClosure($this);
		}
		else
		{
			$format = __("date/$key");
			$this->cache[$key] = function($date) use ($format)
				{
					if( ! $date instanceof DateTime)
						$date = new DateTime($date);
					return __($date->format($format));
				};
		}
		return true;
	}

	/**
	 * Remove duplicate chunks from two <time> tags...
	 */
	private function _simplify($html, Mustache_LambdaHelper $render = null)
	{
		if($render)
			$html = $render($html);

		// Parse HTML
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		$doc->substituteEntities = false;
		// HACK: HTML gets mangled and wrapped as iso-8859-1 unless single root node and string includes encoding O.o
		$doc->loadHTML("<?xml encoding=\"utf-8\" ?><p>$html</p>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		libxml_clear_errors();
		libxml_use_internal_errors(false);

		// Extract node parts
		$tags = $doc->getElementsByTagName('time');
		$t0 = preg_split('/\\s+/', $tags->item(0)->nodeValue);
		$t1 = preg_split('/\\s+/', $tags->item(1)->nodeValue);

		// Remove duplicates
		$t1 = array_diff($t1, $t0);

		// Clean and push back
		$tags->item(0)->nodeValue = trim(implode(' ', $t0), ',');
		if(empty($t1))
			$tags->item(1)->parentNode->removeChild($tags->item(1));
		else
			$tags->item(1)->nodeValue = trim(implode(' ', $t1), ',');


		// HACK: Save each child node of the wrapper <p>
		$html = '';
		foreach($doc->documentElement->childNodes as $node)
			$html .= $doc->saveHTML($node);

		// Trim and return
		return trim($html, "\r\n\t –");
	}
}
