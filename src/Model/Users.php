<?php
namespace Model;

use Data\User;
use Data\Role;
use Error\NotFound;

use Cache;


/**
 * Model: Users.
 */
class Users extends Accounts
{

	/**
	 * All users.
	 */
	public function all(): iterable
	{
		return User::all();
	}


	/**
	 * All users with any of given $roles.
	 */
	public function all_in(array $roles): iterable
	{
		$users = [];
		$roles = Role::choir();

		foreach(User::all() as $user)
			if(array_any($user->roles, $roles))
				yield $user;
	}


	/**
	 * Get user by id or email.
	 */
	public function get($id = null): User
	{
		if(strpos($id, '@') === false)
			return User::get($id);

		foreach(User::all() as $user)
			if($id == $user->email)
				return $user;

		throw new NotFound($id, User::class);
	}
}
