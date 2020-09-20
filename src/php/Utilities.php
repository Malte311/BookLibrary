<?php

defined('BookLib') or die('Bad Request');

/**
 * Provides some useful utilities.
 */
class Utilities {
	/**
	 * String containing small letters, capital letters as well as digits.
	 */
	const DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';

	/**
	 * Array containing the name for all available statistics.
	 */
	const STATISTICS = array('TOTALREAD', 'AVERAGEREAD', 'LASTYEARREAD');

	/**
	 * Checks whether a given authentication code is valid.
	 * @param string $authCode The authentication code to verify.
	 * @return bool True if the given authentication code is valid, else false.
	 */
	public static function isValidAuthCode(string $authCode) : bool {
		return strlen($authCode) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $authCode) === 1;
	}

	/**
	 * Checks whether a given id is valid.
	 * @param string $id The id to verify.
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

	/**
	 * Checks whether a given nonce is valid.
	 * @param string $nonce The nonce to verify.
	 * @return bool True if the given nonce is valid, else false.
	 */
	public static function isValidNonce(string $nonce) : bool {
		return strlen($nonce) <= 50 && preg_match('/^[a-zA-Z0-9]+$/', $nonce) === 1;
	}

	/**
	 * Generates a random string for a given length and a given alphabet.
	 * @param int $length The length for the random string.
	 * @param string $alphabet A list of allowed characters to choose from as a string.
	 * @return string The generated random string.
	 */
	public static function randomString(int $length, string $alphabet) : string {
		$randomString = '';

		$alphabetLength = strlen($alphabet);
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $alphabet[random_int(0, $alphabetLength - 1)];
		}

		return $randomString;
	}

	/**
	 * Checks whether a given file is a markdown file.
	 * @param string $filepath The full path to the file to check.
	 * @return bool True if the file is a markdown file, else false.
	 */
	public static function isMarkdownFile(string $filepath) : bool {
		return is_file($filepath) && pathinfo($filepath)['extension'] === 'md';
	}
}

?>