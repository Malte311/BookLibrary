<?php

defined('BookLib') or die('Bad Request');

/**
 * Maintains the user profiles.
 */
class User {
	/**
	 * Indicates whether the setup has been done or not.
	 */
	private static bool $isSetup = false;

	/**
	 * JsonReader object to deal with json files.
	 */
	private static JsonReader $jsonReader;

	/**
	 * Holds the user data.
	 */
	private static array $userArray = array();

	/**
	 * Initializes the JsonReader object and saves the user list.
	 */
	private static function setup() : void {
		if (!self::$isSetup) {
			self::$jsonReader = new JsonReader('user');
			self::$userArray = self::$jsonReader->getArray();

			self::$isSetup = true;
		}
	}

	/**
	 * Finds the corresponding user id to an user name.
	 * @param string $user The user for which we want to find out the id.
	 * @return string The corresponding id to that user name.
	 */
	public static function getIdByName(string $user) : string {
		self::setup();

		foreach (self::$userArray as $userId => $userName) {
			if ($user === $userName['userName']) {
				return $userName['userId'];
			}
		}

		return '';
	}

	/**
	 * Validates a given authentication code for a specific user.
	 * @param string $id The id of the user for which the authentication code should be validated.
	 * @param string $auth The authentication code to be validated.
	 * @return bool True if the authentication code is correct, else false.
	 */
	public static function validateAuthCode(string $id, string $auth) : bool {
		self::setup();

		if (isset(self::$userArray[$id]) && !empty($auth)) {
			return self::$jsonReader->searchValue([$id, 'codes'], $auth) !== false;
		}

		return false;
	}

	/**
	 * Validates a given password for a specific user.
	 * @param string $user The user name for the user.
	 * @param string $pwd The password for the user.
	 * @return bool True if the password is correct, else false.
	 */
	public static function validatePassword(string $user, string $pwd) : bool {
		self::setup();

		if (!empty($user) && !empty($pwd) && is_string($pwd)) {
			foreach (self::$userArray as $userId => $userName) {
				if ($user === $userName['userName']) {
					if ($userName['pwd'] === hash('sha512', $pwd . $userName['salt'])) {
						return true;
					}
				}
			}

			usleep(random_int(1000000, 2000000));
		}

		return false;
	}
}

?>