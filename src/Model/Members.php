<?php


/**
 * User model.
 */
class Model_Members extends Model
{
	/**
	 * Get single member.
	 */
	public function find($id, $by = 'email')
	{
		foreach($this->all() as $member)
			if($member->$by == $id)
				return $member;
		return false;
	}


	/**
	 * All members
	 */
	public function all()
	{
		foreach(Data_User::index() as $id)
		{
			$member = Data::user($id);
			$member->url = 'members/'.$member->url;
			yield $member;
		}
	}


	/**
	 * For: Members page
	 */
	public function for_members()
	{
		$all = iterator_to_array($this->all());
		shuffle($all);
		return $all;
	}


	/**
	 * For: Tools members page
	 */
	public function for_tools_members()
	{
		$all = iterator_to_array($this->all());
		usort($all, function($a, $b)
		{
			return strcmp($a->first, $b->first);
		});

		$me = Model::user()->logged_in(true);

		foreach($all as $member)
		{
			$member->edit = $me && ($me->admin || $me->id == $member->id)
				? 'tools/members/edit/'.$member->id
				: false;

			yield $member;
		}
	}
}
