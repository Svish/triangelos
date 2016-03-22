<?php


/**
 * User model for handling logins, etc.
 */
class Model_User extends Model
{
	const USER = 'user';



	/**
	 * Try login user.
	 */
	public function login(array $data)
	{
		if( ! Valid::keys_exist($data, ['email', 'password']))
			return false;
		extract($_POST, EXTR_SKIP);

		// Check if member exists
		$member = Model::members()->get($email);
		if( ! $member)
			return false;

		// Check password
		if( ! $member->verify($password))
			return false;

		// Login
		return $this->_login($member);
	}



	/**
	 * Login via link.
	 */
	public function token(array $data)
	{
		extract($data, EXTR_SKIP);

		// If email, create token
		if(isset($email))
		{
			$member = Model::members()->get($email);
			if( ! $member)
				return false;

			$member->make_token();
			return $member;
		}

		// If id, check token
		if(isset($id))
		{
			$member = Model::members()->get($id, 'id');
			if( ! $member)
				return false;

			$result = $member->verify_token($token);
			if($result)
				$this->_login($member);
			return $result;
		}
	}



	private function _login(Data_Member $member)
	{
		$_SESSION[self::USER] = $member->id;
		return true;
	}



	/**
	 * Logout user.
	 */
	public function logout()
	{
		unset($_SESSION[self::USER]);
		return true;
	}



	/**
	 * Get logged in user; false if not logged in.
	 */
	public function logged_in()
	{
		if( ! array_key_exists(self::USER, $_SESSION))
			return false;

		return Model::members()->get($_SESSION[self::USER], 'id');
	}

}
