<?php


/**
 * User model.
 */
class Model_Users extends Model
{
	const DIR = parent::DIR.'users'.DIRECTORY_SEPARATOR;



	public function listing()
	{
		$x = [
			'conductor' => ['name' => 'conductor', 'members' => []],
			'technician' => ['name' => 'technician', 'members' => []],
			'soprano' => ['name' => 'soprano', 'members' => []],
			'alto' => ['name' => 'alto', 'members' => []],
			'tenor' => ['name' => 'tenor', 'members' => []],
			'bass' => ['name' => 'bass', 'members' => []],
		];

		foreach($this->all() as $user)
			$x[$user->role]['members'][] = $user;
		
		foreach($x as &$role)
			usort($role['members'], function($a, $b)
			{
				return strcmp($a->first, $b->first);
			});

		return array_values($x);
	}

	public function find($id)
	{
		$p = is_numeric($id) ? 'id' : 'email';
		foreach ($this->all as $user)
			if($user->$p == $id)
				return $user;
	}


	public function all()
	{
		foreach(glob(self::DIR.'*.json') as $file)
		{
			$data = json_decode(File::get($file));
			$data->id = pathinfo($file, PATHINFO_FILENAME);
			yield $data->id => $data;
		}
	}
}
