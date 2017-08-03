<?php
namespace View;

use Data\Role;
use Model;
use Cache\I18N as Cache;


/**
 * View: members
 */
class Members extends \View\Layout
{


	/**
	 * TODO: Cache shuffled list for a time.
	 *  - Clear on changes in user or images/u. 
	 *  - Make Cache\Validator\Directory(has changes)
	 */
	public function members(): iterable
	{
		$cache = new Cache(__CLASS__, 1800, \Data\User::DIR);
		return $cache->get(__METHOD__, [$this, '_load']);
	}


	public function _load(): iterable
	{
		$choir = Role::choir();

		foreach(Model::users()->all_in($choir) as $user)
			$x[] = [
				'id' => $user->id,
				'first' => $user->first,
				'roles' => array_values(array_intersect($user->roles, $choir)),
			];
		shuffle($x);
		return $x;
	}
}
