<?php

defined('BookLib') or die('Bad Request');

/**
 * Manages different views.
 */
class View {
	/**
	 * Holds the template object to manipulate html files.
	 */
	protected Template $template;

	/**
	 * Initializes the template object.
	 * @param Template $template The template object to manipulate html content.
	 */
	public function __construct(Template $template) {
		$this->template = $template;
	}

	/**
	 * Outputs the html for this view.
	 */
	public function show() : void {
		$this->template->displayHtml();
	}
}

?>