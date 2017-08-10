<?php

namespace Model;

use Cache;
use Config;

use ICal\Parser as Parser;
use Recurr\Transformer\Constraint\AfterConstraint;

use DateInterval;
use DateTimeInterface;
use DateTimeImmutable;



/**
 * Calendar model.
 */
class Calendar extends \Model
{
	// List of event names that should be marked private (for members only)
	const MEMBERS_ONLY = [
		'Choir practice',
		'Warmup',
		'Choir trip',
		];

	private $_ical;



	public function __construct()
	{
		$ical = Config::calendar()['ical'];
		$cache = new Cache(__CLASS__, 1*60*60); // 1 Hour

		$this->_ical = $cache->get('ical', function() use ($ical)
			{
				return file($ical, FILE_IGNORE_NEW_LINES);
			});
	}



	/**
	 * Raw, plain text, ical file.
	 */
	public function raw()
	{
		return implode("\r\n", $this->_ical);
	}



	/**
	 * Upcoming non-private, non-tentative, events.
	 */
	public function upcoming($count = 2): iterable
	{
		$today = new DateTimeImmutable('today');

		foreach($this->_events($today) as $date)
			foreach($date as $event)
				if( ! $event['private'] && $event['status'] !== 'tentative')
					if($count-- > 0)
						yield $event;
					else
						return;
	}



	/**
	 * Calendar for calendar page.
	 */
	public function calendar(): array
	{
		// Begin first of current month
		$first = new DateTimeImmutable('midnight first day of 0 month');
		$today = new DateTimeImmutable('today');

		// Get events
		$events = $this->_events($first);

		// Find last date for calendar
		if( ! empty($events))
		{
			$last = end($events);
			$last = end($last);
			$last = $last['end']->modify('last day of 0 month');
		}
		else
			$last = new DateTimeImmutable('last day of 0 month');

		// Generate calendar strucuture
		$cal = [];
		foreach(self::_days($first, $last) as $day)
		{
			// Month
			$month = $day->format('Y-m');

			// New month
			if( ! array_key_exists($month, $cal))
				$cal[$month] = [
					'month' => $month,
					'weeks' => [],
					];

			// Week
			$week = (int) $day->format('W');
			if($day->format('w') == '0') $week++; // Biblical week adjustment

			// New week
			if( ! array_key_exists($week, $cal[$month]['weeks']))
			{
				$cal[$month]['weeks'][$week] = [
					'week' => $week,
					'days' => array_pad([], $day->format('w'), []),
					];
			}

			// Mark past weeks
			$cal[$month]['weeks'][$week]['past'] = $day < $today ? 'past' : false;


			// New day
			$cal[$month]['weeks'][$week]['days'][(int) $day->format('w')] = [
				'day' => $day,
				'events' => $events[$day->format('Y-m-d')] ?? [],
				];
		}


		// Finally, clean up for mustache traversing
		foreach($cal as &$month)
		{
			foreach($month['weeks'] as &$week)
				$week['days'] = array_values($week['days']);
			$month['weeks'] = array_values($month['weeks']);
		}
		return array_values($cal);
	}



	/**
	 * @return Event array ready for calendar().
	 */
	private function _events(DateTimeInterface $after): array
	{
		$events = [];
		$cal = (new Parser)
			->parse($this->_ical)
			->setConstraint(new AfterConstraint($after, true));

		// Gather events
		foreach($cal->expanded() as $e)
		{
			unset($e['_raw']);
			$e['summary'] = preg_replace('/^Triangelos:\\s/', '', $e['summary']);
			$e['private'] = $this->_is_private($e) ? 'private' : false;
			$e['location'] = preg_replace('/\\s*,\\s*/', "\r\n", $e['location']);

			// Add to list
			$day = $e['start'];
			do
			{
				$events[$day->format('Y-m-d')][] = $e;
				
				// For events over multiple days
				$e['continued'] = 'continued';
				$day = $day->add(new DateInterval('P1D'));
			}
			while($day < $e['end']);
		}

		// Sort the events
		ksort($events);
		foreach($events as &$date)
			if(count($date) > 1)
				usort($date, function($a, $b)
				{
					$a = $a['start'];
					$b = $b['start'];
					if($a == $b)
						return 0;
					return $a < $b ? -1 : 1;
				});
			
		return $events;
	}



	private function _is_private(array $event)
	{
		if($event['transp'] !== 'opaque')
			return true;

		return in_array($event['summary'], self::MEMBERS_ONLY);
	}



	private static function _days(DateTimeImmutable $first, DateTimeImmutable $last): iterable
	{
		$one = new DateInterval('P1D');
		while($first <= $last)
		{
			yield clone $first;
			$first = $first->add($one);
		}
	}
}
