<?php

/**
 * ICal parser.
 *
 * @see http://icalendar.org
 * @see https://tools.ietf.org/html/rfc5545
 * @see http://stackoverflow.com/a/11040109/39321
 */
class ICalendar
{
	public static function fromFile($file)
	{
		$lines = self::read($file);
		$lines = self::unfold($lines);
		$lines = self::parse($lines);
		$lines = self::gather($lines);

		return $lines;
	}



	/**
	 * Gather components.
	 */
	private static function gather(Iterator $lines)
	{
		$component = [];
		while ($lines->valid())
		{
			$line = $lines->current();
			$lines->next();

			if($line['name'] == 'BEGIN')
			{
				$component[$line['value']][] = self::gather($lines);
				continue;
			}

			if($line['name'] == 'END')
				return $component;

			$component[$line['name']] = $line;
		}
		
		return $component['VCALENDAR'][0];
	}



	/**
	 * Yields each line as a parsed assoc array.
	 */
	private static function parse(Iterator $lines)
	{
		foreach($lines as $line)
		{
			if(empty($line) || strpos($line, ':') === FALSE)
				continue;

			// Try get name, value and parameters from lien
			if( ! preg_match('/'.self::RX_CONTENT_LINE.'/Ax', $line, $result))
				continue;

			// Parse parameters into individual ones
			preg_match_all('/'.self::RX_PARAMS.'/Ax', $result['parameters'], $parameters, PREG_SET_ORDER);
			$result['parameters'] = [];
			foreach($parameters as $p)
			{
				$result['parameters'][$p['param_name']] = self::parseValue($p['param_value']);
			}

			// Return parsed line
			yield [
				'name' => $result['name'],
				'value' => self::parseValue($result['value']),
				'params' => $result['parameters'],
				//'raw' => $line,
			];
		}
	}


	/**
	 * Yields each line, unfolded.
	 * @see https://tools.ietf.org/html/rfc5545#section-3.1
	 *
	 * FOO: fo
	 *  obar
	 * 
	 * FOO: foobar
	 */
	private static function unfold(Iterator $lines)
	{
		if( ! $lines->valid())
			return;

		$prev = $lines->current();
		$lines->next();

		while ($lines->valid())
		{
			$line = $lines->current();

			if(preg_match('/[[:blank:]]/A', $line))
			{
				$prev .= substr($line, 1);
			}
			else
			{
				yield $prev;
				$prev = $line;
			}

			$lines->next();
		}

		yield $prev;
	}



	/**
	 * Yields each line of the given file.
	 */
	private static function read($file)
	{
		$fp = fopen($file, 'rb');
		if( ! $fp)
			return;
		
		while(($line = fgets($fp)) !== false)
			yield rtrim($line, "\r\n");

		fclose($fp);
	}



	/**
	 * Parse a value into either null, a single unescaped value or multiple unescaped values.
	 */
	private static function parseValue($value)
	{
		// Split into multiple values
		$values = preg_split('/'.self::RX_VALUES.'/', $value, -1, PREG_SPLIT_NO_EMPTY);

		// Null if empty
		if(empty($values))
			return null;

		// Trim quotes and unescape
		array_walk($values, function(&$val)
			{
				$val = trim($val, '"');
				$val = self::unescape($val);
			});

		// As string if single value; otherwise array
		return count($values) == 1
			? $values[0]
			: $values;

	}



	/**
	 * Unescape a value.
	 * @see https://tools.ietf.org/html/rfc5545#section-3.3.11
	 */
	private static function unescape($string)
	{
		$s = ['\\\\', '\\N', '\\n', '\\;', '\\,'];
		$r = ['\\',   "\n",  "\n",  ';',   ','];
		return str_replace($s, $r, $string);
	}





	/**
	 * Matches content lines.
	 */
	const RX_CONTENT_LINE = '
		(?<name> [^[:cntrl:]";:,]+ )
		(?<parameters> (?: '.self::RX_PARAMS.' )*)
		:
		(?<value> (?:[^\S]|[^[:cntrl:]])* )';

	/**
	 * Matches parameters.
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
	 * Matches unescaped commas.
	 */
	const RX_VALUES = '(?<![^\\\\]\\\\),';
}
