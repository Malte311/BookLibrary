<?php

defined('BookLib') or die('Bad Request');

/**
 * Maintains the user profiles.
 */
class User {
	/**
	 * Finds the corresponding user name to an id.
	 * @param string $id The id for which we want to find out the user name.
	 * @return string The corresponding user name to that id.
	 */
	public static function get_id_by_name(string $id) : string {
		return '';
	}

	/**
	 * Validates a given authentication code for a specific user.
	 * @param string $id The id of the user for which the authentication code should be validated.
	 * @param string $auth The authentication code to be validated.
	 * @return bool True if the authentication code is correct, else false.
	 */
	public static function validate_auth_code(string $id, string $auth) : bool {
		return false;
	}

	/**
	 * Validates a given password for a specific user.
	 * @param string $user The user name for the user.
	 * @param string $pwd The password for the user.
	 * @return bool True if the password is correct, else false.
	 */
	public static function validate_password(string $user, string $pwd) : bool {
		return false;
	}
}

?>