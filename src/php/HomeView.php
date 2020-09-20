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

		$this->loadTypes();
		$this->loadStatistics();
		$this->loadBooks();
	}

	/**
	 * Fetches statistics and adds them to the html template.
	 */
	private function loadStatistics() : void {
		foreach ($this->bookManager->getStats() as $key => $value) {
			$this->template->addReplacement("%%{$key}%%", $value);
		}
	}

	/**
	 * Fetches all available types and displays them as filter options.
	 */
	private function loadTypes() : void {
		$allTypes = array_map(function($e) {
			return (new Template('type'))->addReplacement('%%TYPE%%', $e)->getHtml();
		}, $this->bookManager->getTypes());

		sort($allTypes, SORT_STRING | SORT_FLAG_CASE);

		$this->template->addReplacement("%%ALLTYPES%%", implode('', $allTypes));
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
			$bookTemplate->addReplacement('%%SERVERURL%%', $serverUrl)
				->addReplacement('%%FILENAME%%', $book)
				->addReplacement('%%BOOKTITLE%%', $data);
			
			$dataString .= $bookTemplate->getHtml();
		}

		$this->template->addReplacement('%%BOOKOVERVIEW%%', $dataString);
	}
}

?>