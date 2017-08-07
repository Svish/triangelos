<?php

namespace Model;

use Cache;
use Markdown;
use ICalParser as Parser;

use DateTime;
use DateInterval;


/**
 * Calendar model.
 */
class Calendar extends \Model
{
	// URL to shared iCalendar file
	const ICAL = 'https://sharing.calendar.live.com/calendar/private/3794e2fa-c705-4523-a379-a65187312020/8e8c11c8-8d8f-40d0-bcfe-ca1478af22a0/cid-4a7c4549b6307161/calendar.ics';

	// List of event names that should be marked private (for members only)
	private static $private = [
		'Choir practice',
		'Warmup',
		'Choir trip',
		];


	
	private $ical;
	public function __construct()
	{
		$this->ical = new Parser(self::ICAL);
	}



	/**
	 * Raw ical file.
	 */
	public function ical()
	{
		return $this->ical->raw();
	}



	/**
	 * Next two public events
	 */
	public function up_next()
	{
		$cache = new Cache(__CLASS__, false, 3600); // 1 hour
		return $cache->get(__METHOD__, function()
			{
				return $this->_up_next();
			});
	}
	private function _up_next()
	{
		$today = new DateTime('today');
		$count = 2;

		foreach($this->events($today) as $date)
			foreach($date as $event)
				if( ! $event['private'])
					if($count-- > 0)
						yield $event;
					else
						return;
	}



	/**
	 * Calendar for calendar page.
	 */
	public function calendar()
	{
		$cache = new Cache(__CLASS__, 3600); // 1 hour
		return $cache->get(__METHOD__, function()
			{
				return $this->_calendar();
			});
	}
	private function _calendar()
	{
		// Begin first of current month
		$first = new DateTime('midnight first day of 0 month');
		$today = new DateTime('today');

		// Get events
		$events = $this->events($first);
		$events = [];

		// Find last date for calendar
		if( ! empty($events))
		{
			$last = end($events);
			$last = end($last);
			$last = clone $last['end'];
			$last->modify('last day of 0 month 23:59:59');
		}
		else
			$last = new DateTime('last day of 0 month 23:59:59');

		// Generate calendar strucuture
		$cal = [];
		foreach(self::days($first, $last) as $day)
		{
			// Month
			$month = $day->format('Y-M');
			if( ! array_key_exists($month, $cal))
				$cal[$month] = [
					'month' => $month,
					'weeks' => [],
					];

			// Week
			$week = (int) $day->format('W') % 53;
			if($day->format('w') == '0') $week++; // Biblical week adjustment
			if( ! array_key_exists($week, $cal[$month]['weeks']))
			{
				$cal[$month]['weeks'][$week] = [
					'week' => $week,
					'days' => [],
					];
			}
			$cal[$month]['weeks'][$week]['past'] = $day < $today ? 'past' : false;


			// Day
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

			while(count($month['weeks'][0]['days']) != 7)
				array_unshift($month['weeks'][0]['days'], []);
		}
		return array_values($cal);
	}



	private function events(DateTime $first)
	{
		$cache = new Cache(__CLASS__, 3600); // 1 hour
		return $cache->get(__METHOD__, function() use ($first)
			{
				return $this->_events($first);
			});
	}
	private function _events(DateTime $first)
	{
		$events = [];
		$id = 0;
		foreach($this->ical->events($first) as $e)
		{
			// Add some ids for detail-linking
			$e += ['id' => ++$id];

			// Add type/category
			$e['private'] = self::is_private($e);
			
			// Render description
			$e['description'] = Markdown::instance()->render($e['description'] ?? '');

			// Format location
			$e['location'] = str_replace(',', "\r\n", $e['location']);

			// Add to list
			$events[$e['start']->format('Y-m-d')][] = $e;

			// Copy if it goes over multiple days
			$next = clone $e['start'];
			$next->add(new DateInterval('P1D'));
			foreach($this->days($next, $e['end']) as $day)
			{
				$e['continued'] = 'continued';
				$events[$day->format('Y-m-d')][] = $e;
			}
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

	private static function is_private(array $event)
	{
		return $event['transp'] !== 'opaque' || in_array($event['summary'], self::$private)
			? 'private'
			: false;
	}


	public static function days(DateTime $first, DateTime $last)
	{
		$date = clone $first;
		$one = new DateInterval('P1D');
		while($date <= $last)
		{
			yield clone $date;
			$date->add($one);
		}
	}
}
