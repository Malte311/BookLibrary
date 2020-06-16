<?php

defined('BookLib') or die('Bad Request');

/**
 * Handles user logins.
 */
class Login {
	/**
	 * Holds the time in seconds until a user is logged out (when being inactive).
	 */
	private int $logout_secs = 1200;

	/**
	 * Starts a new session or continues the current session.
	 */
	public function __construct() {
		session_start();
	}

	/**
	 * Ends the current session.
	 */
	public function __destruct() {
		session_write_close();
	}

	/**
	 * Handles incoming GET and POST requests.
	 */
	public function handleRequests() : void {
		$time_out = ($_SESSION['login_time'] + $this->logout_secs) <= time();
		
		if ($_SESSION['login'] !== true || isset($_GET['logout']) || $time_out) {
			if (!empty($_POST['user']) && !empty($_POST['pwd'])) {
				$this->loginPassword();
			} elseif (isset($_GET['id']) && !empty($_GET['auth'])) {
				$this->loginAuthCode();
			} elseif (isset($_GET['logout'])) {
				$this->logout();
			}
		}
	}

	/**
	 * Checks if the current session is logged in.
	 * @return bool True if the session is logged in, else false.
	 */
	public function isLoggedIn() : bool {
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
	private function loginAuthCode() : void {
		$b = Utilities::isValidAuthCode($_GET['auth']) && Utilities::isValidId($_GET['id']);
		
		if ($b && User::validateAuthCode($_GET['id'], $_GET['auth'])) {
			$this->login($_GET['id']);
		} else {
			echo "Login failed.";
		}
	}

	/**
	 * Tries to login via username and password.
	 */
	private function loginPassword() : void {
		$b = Utilities::isValidUserName($_POST['user']);

		if ($b && User::validatePassword($_POST['user'], $_POST['pwd'])) {
			$this->login(User::getIdByName($_POST['user']));
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