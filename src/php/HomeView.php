<?php

defined('BookLib') or die('Bad Request');

/**
 * Displays the home page after logging in.
 */
class HomeView extends View {
	/**
	 * Initializes the template object.
	 * @param Template $template The template object to manipulate html content.
	 */
	public function __construct(Template $template) {
		View::__construct($template);

		$this->loadStatistics();
	}

	/**
	 * Fetches statistics and adds them to the html template.
	 */
	private function loadStatistics() : void {
		$bookStats = new BookStats();
		
		$statsArray = array('TOTALREAD', 'AVERAGEREAD', 'LASTYEARREAD');
		foreach ($statsArray as $val) {
			$stats = $bookStats->getStats($val);
			$this->template->addReplacement("%%{$val}%%", empty($stats) ? 0 : $stats);
		}
	}
}

?>