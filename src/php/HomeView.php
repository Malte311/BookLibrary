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
		$this->loadTypes();
		$this->loadCategories();
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
	 * Fetches all available categories and displays them as filter options.
	 */
	private function loadCategories() : void {
		$allCats = array_map(function($e) {
			return (new Template('cats'))->addReplacement('%%CAT%%', $e)->getHtml();
		}, $this->bookManager->getCategories());

		sort($allCats, SORT_STRING | SORT_FLAG_CASE);

		$this->template->addReplacement("%%ALLCATS%%", implode('', $allCats));
	}

	/**
	 * Fetches books for the current selection and adds them to the html template.
	 */
	private function loadBooks() : void {
		$bookData = $this->bookManager->getBookData();

		$bookData = array_map(function($key, $val) {
			$serverUrl = !empty($_ENV['SERVERURL']) ? $_ENV['SERVERURL'] : 'http://localhost:8000';
			$img = $this->bookManager->hasCover($key) ? str_replace('.md', '', $key) : 'alt';

			return (new Template('book'))->addReplacement('%%SERVERURL%%', $serverUrl)
				->addReplacement('%%FILENAME%%', $img)
				->addReplacement('%%BOOKTITLE%%', $val['title'])
				->getHtml();
		}, array_keys($bookData), $bookData);

		$this->template->addReplacement('%%BOOKOVERVIEW%%', implode('', $bookData));
	}
}

?>