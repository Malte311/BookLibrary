<?php

defined('BookLib') or die('Bad Request');

/**
 * Handles user logins.
 */
class Login {
	/**
	 * Holds the time in seconds until a user is logged out (when being inactive).
	 */
	private int $logoutSecs = 1200;

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
		$timeOut = ($_SESSION['loginTime'] + $this->logoutSecs) <= time();
		
		if ($_SESSION['login'] !== true || isset($_GET['logout']) || $timeOut) {
			if (!empty($_POST['user']) && !empty($_POST['pwd'])) {
				$this->loginPassword();
			} else if (isset($_GET['id']) && !empty($_GET['auth'])) {
				$this->loginAuthCode();
			} else if (isset($_GET['logout'])) {
				$this->logout();
			}
		}
	}

	/**
	 * Checks if the current session is logged in.
	 * @return bool True if the session is logged in, else false.
	 */
	public function isLoggedIn() : bool {
		$b = is_numeric($_SESSION['userId']) && $_SESSION['login'] === true
			&& $_SESSION["ipAddr"] === $_SERVER['REMOTE_ADDR']
			&& $_SESSION["userAgent"] === $_SERVER['HTTP_USER_AGENT']
			&& ($_SESSION['loginTime'] + $this->logoutSecs) > time();

		if ($b) {
			$_SESSION['loginTime'] = time();
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
	 * @param string $userId The id of the user who wants to log in.
	 */
	private function login(string $userId) : void {
		$_SESSION['login'] = true;
		$_SESSION['userId'] = $userId;
		$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['ipAddr'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['loginTime'] = time();
	}

	/**
	 * Logs out the current user.
	 */
	private function logout() : void {
		$_SESSION['login'] = false;
	}
}

?>