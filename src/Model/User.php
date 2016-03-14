<?php


/**
 * User model for logging in, etc.
 */
class Model_User extends Model
{
	const KEY = 'user';



	/**
	 * Try login user.
	 */
	public function login(array $data)
	{
		// Check input
		if( ! Valid::keys_exist($data, ['email', 'password']))
			return false;

		extract($_POST, EXTR_SKIP);

		// Check member exists and password is valid
		$member = Model::members()->get($email);
		if( ! $member || ! $member->verify($password))
			return false;

		// Set session
		$_SESSION[self::KEY] = $member->id;
		return true;
	}



	/**
	 * Logout user.
	 */
	public function logout()
	{
		unset($_SESSION[self::KEY]);
	}



	/**
	 * Get logged in user; false if not logged in.
	 */
	public function logged_in()
	{
		if( ! array_key_exists(self::KEY, $_SESSION))
			return false;

		return Model::members()->get($_SESSION[self::KEY], 'id');
	}

}
