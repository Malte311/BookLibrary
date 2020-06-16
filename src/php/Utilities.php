<?php

defined('BookLib') or die('Bad Request');

/**
 * Provides some useful utilities.
 */
class Utilities {
	/**
	 * Checks whether a given authentication code is valid.
	 * @param string $auth_code The authentication code to verify.
	 * @return bool True if the given authentication code is valid, else false.
	 */
	public static function isValidAuthCode(string $auth_code) : bool {
		return strlen($auth_code) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $auth_code) === 1;
	}

	/**
	 * Checks whether a given id is valid.
	 * @param string $auth_code The id to verify.
	 * @return bool True if the given id is valid, else false.
	 */
	public static function isValidId(string $id) : bool {
		return strlen($id) <= 5 && preg_match('/^[0-9]+$/', $id) === 1;
	}

	/**
	 * Checks whether a given user name is valid.
	 * @param string $user The user name to verify.
	 * @return bool True if the given user name is valid, else false.
	 */
	public static function isValidUserName(string $user) : bool {
		return strlen($user) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $user) === 1;
	}
}

?>