<?php

defined('BookLib') or die('Bad Request');

/**
 * Displays the home page after logging in.
 */
class HomeView extends View {
	public function __construct(Template $template) {
		View::__construct($template);
	}
}

?>