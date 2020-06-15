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

	/**
	 * Checks if the current session is logged in.
	 * @return bool True if the session is logged in, else false.
	 */
	public function isLoggedIn() : bool {
		
	}

	/**
	 * Tries to login via an authentication code.
	 */
	private function login_auth_code() : void {
		if (Utilities::is_valid_auth_code($_GET['auth']) && Utilities::is_valid_id($_GET['id'])) {
			
		} else {
			echo "Login failed.";
		}
	}

	/**
	 * Tries to login via username and password.
	 */
	private function login_password() : void {

	}

	/**
	 * Logs the current session in.
	 * @param string $user_id The id of the user who wants to log in.
	 */
	private function login(string $user_id) : void {
		$_SESSION['login'] = '';
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['ip_addr'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['login_time'] = time();
	}

	/**
	 * Logs out the current user.
	 */
	private function logout() : void {
		$_SESSION['login'] = false;
	}
}

?>