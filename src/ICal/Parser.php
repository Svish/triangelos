<?php

namespace ICal;

use ArrayIterator;
use Iterator;


/**
 * ICal parser.
 *
 * @see http://icalendar.org
 * @see https://tools.ietf.org/html/rfc5545
 * @see http://stackoverflow.com/a/11040109/39321
 */
class Parser
{
	/**
	 * Loads from a file.
	 * @param string $file Path to file
	 */
	public function parseFile(string $file): Calendar
	{
		$file = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		return $this->parse($file);
	}


	/**
	 * Loads from an array of a file.
	 * @param iterable $lines The lines of a file; without new-lines.
	 */
	public function parse(array $lines): Calendar
	{
		$lines = new ArrayIterator($lines);
		$lines = $this->_unfold($lines);
		$lines = $this->_parse($lines);
		$lines = $this->_group($lines);
		return new Calendar($lines);
	}


	/**
	 * Yields each line, unfolded.
	 *
	 *     FOO: fo
	 *      obar
	 *     
	 *     FOO: foobar
	 * 
	 * @see https://tools.ietf.org/html/rfc5545#section-3.1
	 */
	private function _unfold(Iterator $lines): iterable
	{
		if( ! $lines->valid())
			return;

		$current = $lines->current();
		$lines->next();

		while ($lines->valid())
		{
			$next = $lines->current();

			// Append next to current if starting with tab/space
			if(preg_match('/[[:blank:]]/A', $next))
			{
				$current .= substr($next, 1);
			}
			// Otherwise move to next
			else
			{
				yield $current;
				$current = $next;
			}

			$lines->next();
		}

		yield $current;
	}



	/**
	 * Yields each line, as a parsed assoc array, with unescaped values.
	 */
	private function _parse(iterable $lines): iterable
	{
		foreach($lines as $line)
		{
			if(empty($line) || strpos($line, ':') === FALSE)
				continue;

			// Try parse line
			if( ! preg_match('/'.self::RX_CONTENT_LINE.'/Ax', $line, $result))
				continue;

			// Name
			$x = ['name' => strtoupper($result['name'])];

			// Value
			$value = $this->_parseValue($result['value']);
			if($value !== null)
				$x['value'] = $value;

			// Parse parameters into individual ones
			preg_match_all('/'.self::RX_PARAMS.'/Ax', $result['parameters'], $parameters, PREG_SET_ORDER);
			foreach($parameters as $p)
				$x['params'][$p['param_name']] = $this->_parseValue($p['param_value']);

			yield $x;
		}
	}



	/**
	 * Recursively group components into one assoc array.
	 */
	private function _group(Iterator $lines): array
	{
		$component = [];
		while ($lines->valid())
		{
			$line = $lines->current();
			$lines->next();

			if($line['name'] == 'BEGIN')
			{
				$component[$line['value']][] = $this->_group($lines);
				continue;
			}

			if($line['name'] == 'END')
				return $component;

			$component[$line['name']] = $line;
		}
		
		return $component['VCALENDAR'][0];
	}



	/**
	 * Parse a value into either null, a single unescaped value or multiple unescaped values.
	 */
	private function _parseValue(string $value)
	{
		// Split into multiple values
		$values = preg_split('/'.self::RX_VALUES.'/', $value, -1, PREG_SPLIT_NO_EMPTY);

		// No value
		if(empty($values))
			return null;

		// Trim quotes and unescape
		array_walk($values, function(&$val)
			{
				$val = trim($val, '"');
				$val = $this->_unescape($val);
				$val = trim($val);
			});

		// As array if more than one
		if(count($values) > 1)
			return $values;

		// Otherwise as string|null
		return $values[0] === '' ? null : $values[0];
	}



	/**
	 * Unescape a value.
	 * @see https://tools.ietf.org/html/rfc5545#section-3.3.11
	 */
	private function _unescape(string $string): string
	{
		$s = ['\\\\', '\\N', '\\n', '\\;', '\\,'];
		$r = ['\\',   "\n",  "\n",  ';',   ','];
		return str_replace($s, $r, $string);
	}



	/**
	 * Regex: Content lines.
	 */
	const RX_CONTENT_LINE = '
		(?<name> [^[:cntrl:]";:,]+ )
		(?<parameters> (?: '.self::RX_PARAMS.' )*)
		:
		(?<value> (?:[^\S]|[^[:cntrl:]])* )';

	/**
	 * Regex: Parameters.
	 */
	const RX_PARAMS = '
		;
		(?<param_name> [^[:cntrl:]";:,]+ )
		=
		(?<param_value> 
			(?:       " (?:[^\S]|[^[:cntrl:]"])* " | (?:[^\S]|[^[:cntrl:]";:,])* )
			(?: , (?: " (?:[^\S]|[^[:cntrl:]"])* " | (?:[^\S]|[^[:cntrl:]";:,])* ) )*
		)';

	/**
	 * Regex: Unescaped commas.
	 */
	const RX_VALUES = '(?<![^\\\\]\\\\),';
}
