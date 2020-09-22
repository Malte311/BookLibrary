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
		$baseUrl = !empty($_ENV['BASEURL']) ? $_ENV['BASEURL'] : 'http://localhost:8000';
		$impressum = !empty($_ENV['IMPRESSUMURL']) ? $_ENV['IMPRESSUMURL'] : '';
		$datenschutz = !empty($_ENV['DATENSCHUTZURL']) ? $_ENV['DATENSCHUTZURL'] : '';

		$template->addReplacement('%%YEAR%%', date('Y'))->addReplacement('%%BASEURL%%', $baseUrl)
			->addReplacement('%%IMP%%', $impressum)->addReplacement('%%DS%%', $datenschutz);
		
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