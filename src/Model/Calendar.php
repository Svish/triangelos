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


		// Gather events and find end date for calendar
		$last = clone $first;
		$events = [];
		foreach($this->ical->events($first) as $e)
		{
			$last = clone max($last, $e['start'], $e['end']);
			$events[$e['start_date']][] = $e;

			$next = clone $e['start'];
			$next->add(new DateInterval('P1D'));
			foreach($this->days($next, $e['end']) as $day)
			{
				$e['summary'] = '←';
				$events[$day->format('Y-m-d')][] = $e;
			}
		}
		

		// Push end date to last of month
		$last->modify('last day of 0 month 23:59:59');

		// Sort the events, if necessary
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


		// Generate calendar strucuture
		$cal = [];
		foreach($this->days($first, $last) as $day)
		{
			// Month
			$month = $day->format('Y-M');
			if( ! array_key_exists($month, $cal))
				$cal[$month] = [
					'name' => $day->format('F'),
					'year' => $day->format('Y'),
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

			// Day
			$ymd = $day->format('Y-m-d');
			$cal[$month]['weeks'][$week]['days'][(int) $day->format('w')] = [
				'date' => $day,
				'day' => $day->format('j'),
				'iso' => $ymd,
				'name' => $day->format('l'),
				'events' => Util::path($events, $ymd, []),
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


	private function days(DateTime $first, DateTime $last)
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
