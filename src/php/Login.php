<?php

defined('BookLib') or die('Bad Request');

/**
 * Handles user logins.
 */
class Login {
	/**
	 * Holds the time in seconds until a user is logged out (when being inactive).
	 */
	private int $logout_secs = 600;

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
	public function is_logged_in() : bool {
		$b = is_numeric($_SESSION['user_id']) && $_SESSION['login'] === true
			&& $_SESSION["ip_addr"] === $_SERVER['REMOTE_ADDR']
			&& $_SESSION["user_agent"] == $_SERVER['HTTP_USER_AGENT']
			&& ($_SESSION['login_time'] + $this->$logout_secs) > time();

		if ($b) {
			$_SESSION['login_time'] = time();
		}

		return $b;
	}

	/**
	 * Tries to login via an authentication code.
	 */
	private function login_auth_code() : void {
		$b = Utilities::is_valid_auth_code($_GET['auth']) && Utilities::is_valid_id($_GET['id']);
		
		if ($b && User::validate_auth_code($_GET['id'], $_GET['auth'])) {
			$this->login($_GET['id']);
		} else {
			echo "Login failed.";
		}
	}

	/**
	 * Tries to login via username and password.
	 */
	private function login_password() : void {
		$b = Utilities::is_valid_user_name($_POST['user']);

		if ($b && User::validate_password($_POST['user'], $_POST['pwd'])) {
			$this->login(User::get_id_by_name($_POST['user']));
		} else {
			echo "Login failed.";
		}
	}

	/**
	 * Logs the current session in.
	 * @param string $user_id The id of the user who wants to log in.
	 */
	private function login(string $user_id) : void {
		$_SESSION['login'] = true;
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