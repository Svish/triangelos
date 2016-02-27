<?php


/**
 * Calendar model.
 */
class Model_Calendar extends Model
{
	const DIR = 'calendar';
	const ROOT = parent::DIR.self::DIR;

	const ICAL = 'https://sharing.calendar.live.com/calendar/private/3794e2fa-c705-4523-a379-a65187312020/8e8c11c8-8d8f-40d0-bcfe-ca1478af22a0/cid-4a7c4549b6307161/calendar.ics';



	public function listing()
	{
		$calendar = $this->calendar();


		// TODO: Add somehow add events...
		foreach($calendar['date'] as &$date)
			if(rand(0, 5) == 0)
				$date['hasEvents'] = 'events';




		// Clean up for mustache traversing
		unset($calendar['date']);
		foreach($calendar as &$month)
		{
			foreach($month['weeks'] as &$week)
				$week['days'] = array_values($week['days']);

			$month['weeks'] = array_values($month['weeks']);

			while(count($month['weeks'][0]['days']) != 7)
				array_unshift($month['weeks'][0]['days'], []);
		}
		$calendar = array_values($calendar);

		//var_dump($calendar);exit;

		// And done...
		return $calendar;
	}


	private function calendar()
	{
		$today = new DateTime('today');
		$toweek = $today->format('W');

		$begin = clone $today;
		$begin->modify('first day of 0 month');

		$end = clone $today;
		$end->modify('last day of 5 month');


		$cal = ['date' => []];
		foreach($this->days($begin, $end) as $date)
		{
			// Month
			$month = $date->format('Y-M');
			if( ! array_key_exists($month, $cal))
				$cal[$month] = [
					'name' => $date->format('F'),
					'year' => $date->format('Y'),
					'weeks' => [],
					];

			// Week
			$week = (int) $date->format('W');
			if( ! array_key_exists($week, $cal[$month]['weeks']))
			{
				$cal[$month]['weeks'][$week] = [
					'week' => $week,
					'isCurrent' => $toweek == $week ? 'current' : '',
					'days' => [],
					];
			}

			// Day
			$day = (int) $date->format('w');
			$cal[$month]['weeks'][$week]['days'][$day] = [
				'date' => $date,
				'day' => $date->format('j'),
				'iso' => $date->format('Y-m-d'),
				'name' => $date->format('l'),
				'isCurrent' => $today == $date ? 'current' : '',
				'events' => [],
				];
			$cal['date'][$date->format('Y-m-d')] = &$cal[$month]['weeks'][$week]['days'][$day];

		}
		return $cal;
	}



	private function days(DateTime $start, DateTime $end)
	{
		$date = clone $start;
		while($date <= $end)
		{
			yield clone $date;
			$date->add(new DateInterval('P1D'));
		}
	}



	public function events()
	{
		$cal = ICalendar::fromFile(self::ICAL);
		var_dump($cal);
		exit;
	}



	public function ical()
	{
		return file_get_contents(self::ICAL);
	}
}
