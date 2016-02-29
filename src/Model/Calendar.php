<?php


/**
 * Calendar model.
 */
class Model_Calendar extends Model
{
	const DIR = 'calendar';
	const ROOT = parent::DIR.self::DIR;

	const ICAL = 'https://sharing.calendar.live.com/calendar/private/3794e2fa-c705-4523-a379-a65187312020/8e8c11c8-8d8f-40d0-bcfe-ca1478af22a0/cid-4a7c4549b6307161/calendar.ics';
	private $ical;



	public function __construct()
	{
		$this->ical = new ICalParser(self::ICAL);
	}



	/**
	 * Raw ical file.
	 */
	public function ical()
	{
		return $this->ical->raw();
	}



	/**
	 * Calendar for calendar page.
	 */
	public function listing()
	{
		// Begin first of current month
		$first = new DateTime('midnight first day of 0 month');
		$today = new DateTime('today');

		// Get events
		$events = $this->events($first);

		// Find last date for calendar
		$last = end($events);
		$last = end($last);
		$last = clone $last['end'];
		$last->modify('last day of 0 month 23:59:59');

		// Generate calendar strucuture
		$cal = [];
		foreach(self::days($first, $last) as $day)
		{
			// Month
			$month = $day->format('Y-M');
			if( ! array_key_exists($month, $cal))
				$cal[$month] = [
					'name' => $day->format(__('date/month-name')),
					'weeks' => [],
					];

			// Week
			$week = (int) $day->format('W');
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
			$iso = $day->format('Y-m-d');
			$cal[$month]['weeks'][$week]['days'][(int) $day->format('w')] = [
				'date' => $day,
				'day' => $day->format(__('date/day')),
				'week' => (int) $day->format('W'),
				'iso' => $iso,
				'name' => $day->format(__('date/day-name')),
				'events' => Util::path($events, $iso, []),
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
		$events = [];
		$id = 0;
		foreach($this->ical->events($first) as $e)
		{
			// Add formatted stuffs
			$e += [
				'id' => ++$id,
				'iso' => $e['start']->format('Y-m-d'),
				'start_date' => $e['start']->format(__('date/date')),
				'start_w3c' => $e['start']->format(DATE_W3C),
				'end_date' => $e['end']->format(__('date/date')),
				'end_w3c' => $e['end']->format(DATE_W3C),
				];

			// Add type/category
			$e['private'] = self::is_private($e);

			// If all day, remove times
			if( ! $e['all_day']) $e += [
				'start_time' => $e['start']->format(__('date/time')),
				'end_time' => $e['end']->format(__('date/time')),
				];

			// If equal dates, remove end date
			if($e['start_date'] == $e['end_date'])
				unset($e['end_date']);
			
			// If equal datetimes, remove end
			if($e['start'] == $e['end'])
				unset($e['end_time'], $e['end_w3c']);

			$e['description'] = Markdown::render($e['description']);
			$e['location'] = str_replace(',', '<br>', $e['location']);

			// Add to list
			$events[$e['iso']][] = $e;

			// Copy if over more days
			$next = clone $e['start'];
			$next->add(new DateInterval('P1D'));
			foreach($this->days($next, $e['end']) as $day)
			{
				$e['first'] = $e['iso'];
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


	private static $private = ['Choir practice', 'Warmup'];

	private static function is_private(array $event)
	{
		return $event['transp'] !== 'opaque' || in_array($event['summary'], self::$private)
			? 'private'
			: false;
	}


	private static function days(DateTime $first, DateTime $last)
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
