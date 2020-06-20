<?php

defined('BookLib') or die('Bad Request');

/**
 * Displays the login form for users to log in.
 */
class LoginView extends View {
	/**
	 * Initializes the view and displays an error message if needed.
	 */
	public function __construct(Template $template) {
		View::__construct($template);

		$this->displayMessage();
	}

	/**
	 * Adds a message to the template if needed.
	 */
	public function displayMessage() : void {
		$re = '';

		if (isset($_GET['loginFailPW'])) {
			$re = '<div class="alert alert-danger" role="alert">Invalid username or password!</div>';
		} else if (isset($_GET['loginFailAuth'])) {
			$re = '<div class="alert alert-danger" role="alert">Invalid authentication code!</div>';
		}

		$this->template->addReplacement('%%MESSAGE%%', $re);
	}
}

?>