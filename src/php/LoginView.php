<?php

defined('BookLib') or die('Bad Request');

/**
 * Displays the login form for users to log in.
 */
class LoginView extends View {
	public function __construct(Template $template) {
		View::__construct($template);
	}
}

?>