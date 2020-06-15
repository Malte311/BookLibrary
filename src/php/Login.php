<?php

defined('BookLib') or die('Bad Request');

/**
 * Handles user logins.
 */
class Login {
	public function __construct() {
		session_start();
	}

	public function __destruct() {
		session_write_close();
	}

	private function login($user_id) {

	}

	private function logout() {
		$_SESSION['login'] = false;
	}
}

?>