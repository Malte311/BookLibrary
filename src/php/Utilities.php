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
	public static function is_valid_auth_code(string $auth_code) : bool {
		return strlen($auth_code) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $auth_code) === 1;
	}

	/**
	 * Checks whether a given id is valid.
	 * @param string $auth_code The id to verify.
	 * @return bool True if the given id is valid, else false.
	 */
	public static function is_valid_id(string $id) : bool {
		return strlen($id) <= 5 && preg_match('/^[0-9]+$/', $id) === 1;
	}
}

?>