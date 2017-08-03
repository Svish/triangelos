<?php

/**
 * ICal parser.
 *
 * @see http://icalendar.org
 * @see https://tools.ietf.org/html/rfc5545
 * @see http://stackoverflow.com/a/11040109/39321
 */
class ICalParser
{
	private $file;
	private $components = null;

	private $transformer;
	private $constraint;



	/**
	 * New ICalParser for given file.
	 */
	public function __construct($file, $rlimit = 52)
	{
		// Setup Recurr
		$config = new \Recurr\Transformer\ArrayTransformerConfig();
		$config->setVirtualLimit($rlimit);
		$this->transformer = new \Recurr\Transformer\ArrayTransformer($config);

		// Load calendar file
		set_time_limit(30);
		$cache = new Cache(__CLASS__, false, 28800); // 8 hours
		$this->file = $cache->get($file, function($f)
			{
				set_time_limit(30);
				return file($f, FILE_IGNORE_NEW_LINES);
			});
	}


	/**
	 * Returns the raw file.
	 */
	public function raw()
	{
		return implode("\r\n", $this->file);
	}



	/**
	 * Yields all event instances in this calendar after the given date.
	 */
	public function events(DateTime $after)
	{
		if($this->components == null)
			$this->load();

		$constraint = new \Recurr\Transformer\Constraint\AfterConstraint(clone $after, true);

		foreach($this->components['VEVENT'] as $event)
			foreach($this->unravel($event, $constraint) as $instance)
				if($constraint->test($instance['start']))
					yield $instance;
	}



	/**
	 * Yield event instances for the event.
	 */
	private function unravel(array $event, \Recurr\Transformer\Constraint\AfterConstraint $constraint)
	{
		// Values same for every instance
		$summary = $event['SUMMARY.value'] ?? null;
		$summary = preg_replace('/^Triangelos:\\s/', '', $summary);
		$description = $event['DESCRIPTION.value'];
		$location = $event['LOCATION.value'];
		$status = strtolower($event['X-MICROSOFT-CDO-BUSYSTATUS.value'] ?? 'BUSY');
		$transp = strtolower($event['TRANSP.value'] ?? 'BUSY');

		// For consistency, pretend everything has an rrule
		$rrule = $event['RRULE.value'] ?? 'FREQ=DAILY;COUNT=1';

		if($r_start = $event['DTSTART.value'] ?? null)
			$rrule .= ";DTSTART=$r_start";
		if($r_end = $event['DTEND.value'] ?? null)
			$rrule .= ";DTEND=$r_end";

		// TODO: Handle multiple EXDATE and RDATE
		if($r_exdate = $event['EXDATE.value'] ?? null)
			$rrule .= ";EXDATE=".(is_array($r_exdate) ? implode(',', $r_exdate) : $r_exdate);
		if($r_rdate = $event['RDATE.value'] ?? null)
			$rrule .= ";RDATE=".(is_array($r_rdate) ? implode(',', $r_rdate) : $r_rdate);

		$rrule = new \Recurr\Rule($rrule);
		$events = $this->transformer->transform($rrule, $constraint);
		
		foreach($events as $e)
		{
			$all_day = 'DATE' == $event['DTSTART.params.VALUE'] ?? null;
			
			$start = $e->getStart();
			$end = $e->getEnd();

			if('DATE' == $event['DTSTART.params.VALUE'] ?? null)
				$end->sub(new DateInterval('PT1S'));

			// Yield wanted event properties
			yield array_intersect_key(get_defined_vars(), array_flip([
				'summary', 'description',
				'location', 'status', 'transp',
				'start', 'end', 'all_day',
				]));
		}
	}



	/**
	 * Load file.
	 */
	private function load()
	{
		$lines = new ArrayIterator($this->file);
		$lines = self::unfold($lines);
		$lines = self::parse($lines);
		$lines = self::gather($lines);

		$this->components = $lines;
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
			// TODO: Do adjustments? DURATION => DTEND?
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
				'name' => strtoupper($result['name']),
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
