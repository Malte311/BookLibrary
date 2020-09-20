<?php

defined('BookLib') or die('Bad Request');

/**
 * Displays the home page after logging in.
 */
class HomeView extends View {
	/**
	 * BookManager object to fetch statistics and books.
	 */
	private BookManager $bookManager;

	/**
	 * Initializes the template object.
	 * @param Template $template The template object to manipulate html content.
	 */
	public function __construct(Template $template) {
		View::__construct($template);

		$this->bookManager = new BookManager();

		$this->loadStatistics();
		$this->loadBooks();
	}

	/**
	 * Fetches statistics and adds them to the html template.
	 */
	private function loadStatistics() : void {
		foreach (Utilities::STATISTICS as $val) {
			$stats = $this->bookManager->getStats($val);
			$this->template->addReplacement("%%{$val}%%", empty($stats) ? 0 : $stats);
		}
	}

	/**
	 * Fetches books for the current selection and adds them to the html template.
	 */
	private function loadBooks() : void {
		$bookData = $this->bookManager->getBookData();
		$serverUrl = !empty($_ENV['SERVERURL']) ? $_ENV['SERVERURL'] : 'http://localhost:8000';

		$bookTemplate = new Template('book');
		$dataString = '';
		foreach ($bookData as $book => $data) {
			$bookTemplate->addReplacement('%%SERVERURL%%', $serverUrl);
			$bookTemplate->addReplacement('%%FILENAME%%', $book);
			$bookTemplate->addReplacement('%%BOOKTITLE%%', $data);
			$dataString .= $bookTemplate->getHtml();
		}

		$this->template->addReplacement('%%BOOKOVERVIEW%%', $dataString);
	}
}

?>