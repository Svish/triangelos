<?php


/**
 * User model.
 */
class Model_Members extends Model
{
	const DIR = 'members/';
	const PATH = parent::DIR.self::DIR.DIRECTORY_SEPARATOR;



	/**
	 * For members page
	 */
	public function listing()
	{
		$x = $this->all();
		shuffle($x);
		return $x;
	}



	/**
	 * Get single member.
	 */
	public function get($id, $by = 'email')
	{
		foreach ($this->all() as $user)
			if($user->$by == $id)
				return $user;
		return false;
	}



	/**
	 * All members.
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

			$data = json_decode(File::get($file), true);
			$data['id'] = $filename;
			$data['url'] = self::DIR.$filename;
			$data['img'] = empty($img) ? 'none' : self::DIR.pathinfo($img[0], PATHINFO_BASENAME);

			yield new Data_Member($data, $file);
		}
	}
}
