<?php


/**
 * User model.
 */
class Model_Members extends Model
{
	const DIR = 'members';
	const PATH = parent::DIR.self::DIR.DIRECTORY_SEPARATOR;



	/**
	 * For members.mustache
	 */
	public function listing()
	{
		// Role order
		$x = [
			'soprano' => ['name' => 'soprano', 'members' => []],
			'alto' => ['name' => 'alto', 'members' => []],
			'tenor' => ['name' => 'tenor', 'members' => []],
			'bass' => ['name' => 'bass', 'members' => []],
			'conductor' => ['name' => 'conductor', 'members' => []],
			'pianist' => ['name' => 'pianist', 'members' => []],
			'technician' => ['name' => 'technician', 'members' => []],
		];

		foreach($this->all() as $user)
			$x[$user->role]['members'][] = $user;

		return array_values($x);
	}



	/**
	 * Single member
	 */
	public function find($id)
	{
		$p = is_numeric($id) ? 'id' : 'email';
		foreach ($this->all as $user)
			if($user->$p == $id)
				return $user;
	}



	/**
	 * All members
	 */
	public function all()
	{
		$cache = new Cache(__CLASS__);
		return $cache->get(__METHOD__, function()
			{
				$x = iterator_to_array($this->_all());
				usort($x, function($a, $b)
				{
					return strcmp($a->first, $b->first);
				});
				return $x;
			}, true);
	}

	private function _all()
	{
		foreach(glob(self::PATH.'*.json') as $file)
		{
			extract(pathinfo($file));

			$img = glob("$dirname/$filename.{jpg,jpeg,png,gif}", GLOB_BRACE);

			$data = json_decode(File::get($file));
			$data->id = $filename;
			$data->img = empty($img) ? 'none' : self::DIR.'/'.pathinfo($img[0], PATHINFO_BASENAME);

			yield $data->id => $data;
		}
	}
}
