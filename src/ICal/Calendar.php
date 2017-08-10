<?php

namespace ICal;

use Recurr\Transformer\ArrayTransformerConfig as Config;
use Recurr\Transformer\ArrayTransformer as Transformer;
use Recurr\Transformer\Constraint;

use DateTimeInterface;
use DateTimeImmutable;
use DateTime;



/**
 * Parsed VCALENDAR.
 */
class Calendar
{
	/**
	 * Date format of DTSTART and DTEND.
	 */
	private const DT_DATETIME = '!Ymd\THis';
	private const DT_DATE = '!Ymd';

	private $_constraint;
	private $_components;
	private $_rt;

	public function __construct(array $components, $rlimit = 52)
	{
		$this->_components = $components;

		// Setup Recurr Transformer
		$c = new Config;
		$c->setVirtualLimit($rlimit);
		$c->enableLastDayOfMonthFix();
		$this->_rt = new Transformer($c);
		
	}


	public function __isset($key)
	{
		return array_key_exists(strtoupper($key), $this->_components);
	}

	public function __get($key)
	{
		return $this->_components[strtoupper($key)] ?? null;
	}


	public function setConstraint(Constraint $constraint)
	{
		$this->_constraint = $constraint;
		return $this;
	}
	

	/**
	 * Yields events with common values normalized.
	 */
	public function events(): iterable
	{
		foreach($this->vevent as $_raw)
		{
			$uid = $_raw['UID']['value'] ?? null;

			$summary = $_raw['SUMMARY']['value'] ?? null;
			$description = $_raw['DESCRIPTION']['value'] ?? null;
			$location = $_raw['LOCATION']['value'] ?? null;
			$status = strtolower($_raw['X-MICROSOFT-CDO-BUSYSTATUS']['value'] 
				?? $_raw['STATUS']['value'] 
				?? 'BUSY');
			$transp = strtolower($_raw['TRANSP']['value']
				?? 'OPAQUE');

			// TODO: DURATION => DTEND?
			if(isset($_raw['DURATION']))
				throw new \LogicException('Need to deal with DURATION...');

			$start = $this->_date($_raw['DTSTART']['value']);
			$end =  $this->_date($_raw['DTEND']['value']);
			$day = 'DATE' == ($_raw['DTSTART']['params']['VALUE'] ?? null);

			yield get_defined_vars();
		}
	}


	/**
	 * Yields events with recurrences expanded.
	 */
	public function expanded(): iterable
	{
		foreach($this->events() as $_raw)
		{
			extract($_raw, EXTR_OVERWRITE);

			// No rrule, just yield single event
			if( ! ($_raw['RRULE']['value'] ?? null))
			{
				if($this->_constraint->test($start))
					yield get_defined_vars();
				continue;
			}

			// For consistency, pretend everything has an rrule
			$rrule = $_raw['RRULE']['value'] ?? 'FREQ=DAILY;COUNT=1';			
			$rrule .= ";DTSTART={$_raw['DTSTART']['value']}";
			$rrule .= ";DTEND={$_raw['DTEND']['value']}";

			// EXDATE
			if($rexdate = self::_implode($_raw['EXDATE']['value'] ?? []))
				$rrule .= ";EXDATE=$rexdate";

			// RDATE
			if($rrdate = self::_implode($_raw['RDATE']['value'] ?? []))
				$rrule .= ";RDATE=$rdate";

			unset($rexdate, $rrdate);

			// Expand rrule
			foreach($this->_rt->transform(new \Recurr\Rule($rrule), $this->_constraint) as $e)
			{
				$start = $this->_date($e->getStart());
				$end = $this->_date($e->getEnd());

				unset($e);
				yield get_defined_vars();
			}

			// Cleanup
			foreach(get_defined_vars() as $k => $v)
				unset($$k);
			unset($k, $v);
		}
	}



	private function _date($date): DateTimeImmutable
	{
		if(is_string($date))
		{
			$f = strpos($date, 'T') === false
				? self::DT_DATE
				: self::DT_DATETIME;
			return DateTimeImmutable::createFromFormat($f, $date);
		}

		if($date instanceof DateTime)
			return DateTimeImmutable::createFromMutable($date);
		
		if($date instanceof DateTimeImmutable)
			return $date;

		throw new \LogicException('Unhandled date type: '.get_class($date));
	}


	private function _implode($subject)
	{
		return is_array($subject)
			? implode(',', $subject)
			: $subject;
	}
}
