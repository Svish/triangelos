<?php

namespace View\Helper;

use Error\InternalNotFound;

use I18N;
use RecursiveArrayIterator as Iterator;
use PathableRecursiveIteratorIterator as Recursor;
use Mustache_LambdaHelper as LambdaHelper;
use ConfigDot as Config;

use DateTimeInterface;
use DateTimeImmutable;
use DOMDocument;


/**
 * Helper: [F]ormatter.
 * 
 * Formats dates n stuff.
 * 
 *     {{ date | f.date-short}}
 */
class F
{
	private $_f = [];
	private $_d;

	public function __construct()
	{
		// Date formats
		$this->_d = Config::dateFormats(INI_SCANNER_NORMAL);

		// Durations
		$this->_f['duration'] = new Duration;

		// Own methods
		foreach(get_class_methods($this) as $name)
			if($name[0] == '_' && $name[1] != '_')
			{
				$m = new \ReflectionMethod($this, $name);
				$this->_f[substr($name, 1)] = $m->getClosure($this);
			}
	}



	public function __isset($key)
	{
		return true;
	}



	public function __get($key)
	{
		if(array_key_exists($key, $this->_f))
			return $this->_f[$key];

		$fk = str_replace('-', '.', $key);
		foreach([LOCALE.'.'.$fk, $fk] as $k)
		{
			$format = $this->_d->get($k);

			if(is_array($format))
				$format = $format[0] ?? null;

			if(is_null($format))
				continue;

			return $this->_f[$key] = function($date) use ($format)
			{
				if( ! $date instanceof DateTimeInterface)
					$date = new DateTimeImmutable($date);
				return I18N::translate($date->format($format));
			};
		}

		throw new InternalNotFound($key, 'date format');
	}


	public function _timeTrim(string $text = null)
	{
		return str_replace(':00', '', $text);
	}


	public function _rrule(string $rrule)
	{
		$rule = new \Recurr\Rule($rrule);
		$tran = new \Recurr\Transformer\TextTransformer;
		return $tran->transform($rule);
	}


	public function _addressLine(string $address)
	{
		return preg_replace('/[\r\n]+/', ',', $address);
	}

	/**
	 * Remove duplicate chunks from two <time> tags...
	 */
	public function _simplify($html, LambdaHelper $render = null)
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
