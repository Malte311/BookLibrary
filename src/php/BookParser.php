<?php

defined('BookLib') or die('Bad Request');

/**
 * Scans directories for book information and parses the information.
 */
class BookParser {
	/**
	 * JsonReader object to deal with json files.
	 */
	private JsonReader $jsonReader;

	/**
	 * Holds the information for the available books.
	 */
	private array $bookData;
	
	/**
	 * Initializes the json reader object.
	 */
	public function __construct() {
		$this->jsonReader = new JsonReader('bookData');
		
		$this->bookData = array();
		foreach (Utilities::STATISTICS as $stat) {
			$this->bookData[$stat] = 0;
		}
	}

	/**
	 * Scans the data/books/ directory for available books and parses their information.
	 * The information is stored in separate json files, available in the data/ directory.
	 * @param string $dir The directory to scan.
	 */
	public function scanDirectory(string $dir = __DIR__ . '/../data/books') : void {
		foreach (scandir($dir) as $index => $file) {
			$filename = "{$dir}/{$file}";

			if (Utilities::isMarkdownFile($filename)) {
				$this->parseFile($filename); // Saves information to $this->bookData
			}
		}

		$this->updateStatistics();
		$this->jsonReader->setArray($this->bookData);
	}

	/**
	 * Parses a given markdown file and saves the book information to the $bookData variable.
	 * @param string $file The file to parse.
	 */
	private function parseFile(string $file) : void {
		$fileData = array();
		$fileContent = file_get_contents($file);

		$fileData['title']      = $this->parseTitle($fileContent);
		$fileData['dates']      = $this->parseDates($fileContent);
		$fileData['types']      = $this->parseTypes($fileContent);
		$fileData['categories'] = $this->parseCategories($fileContent);
		$fileData['content']    = $this->parseContent($fileContent);

		$this->bookData[basename($file)] = $fileData;
	}

	/**
	 * Extracts the book title from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return string The corresponding book title.
	 */
	private function parseTitle(string $fileContent) : string {
		preg_match('/# (.*)((\r?\n)|(\r\n?))/', $fileContent, $matches);

		return !empty($matches) ? preg_replace('/(\r?\n?)/', '', $matches[1]) : '';
	}

	/**
	 * Extracts the dates (when the book was read) from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding dates when the book was read.
	 */
	private function parseDates(string $fileContent) : array {
		preg_match_all('/> (\d\d\.\d\d\.\d\d\d\d)(.*)((\r?\n)|(\r\n?))/', $fileContent, $matches);
		
		return !empty($matches) ? array_map('strtotime', $matches[1]) : array();
	}

	/**
	 * Extracts the types (in which form the book was read, e.g. paperback or ebook)
	 * from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding types in which form the book was read.
	 */
	private function parseTypes(string $fileContent) : array {
		$regex = '/> \d\d\.\d\d\.\d\d\d\d, ([^\r\n]*)((\r?\n)|(\r\n?))/';
		preg_match_all($regex, $fileContent, $matches);

		return !empty($matches) ? array_unique(array_map('rtrim', $matches[1])) : array();
	}

	/**
	 * Extracts the categories from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding categories.
	 */
	private function parseCategories(string $fileContent) : array {
		if (strpos($fileContent, '---') === false) {
			return array();
		}

		$replaceRegex = '/> \d\d\.\d\d\.\d\d\d\d, ([^\r\n]*)((\r?\n)|(\r\n?))/';
		$fileContent = preg_replace($replaceRegex, '', $fileContent);

		$matchRegex = '/> (.*)((\r?\n)|(\r\n?))/';
		preg_match_all($matchRegex, substr($fileContent, 0, strpos($fileContent, '---')), $matches);

		return !empty($matches) ? array_map('rtrim', $matches[1]) : array();
	}

	/**
	 * Extracts the raw content from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return string The corresponding raw content (without title, dates, types, etc.).
	 */
	private function parseContent(string $fileContent) : string {
		if (strpos($fileContent, '---') === false) {
			return '';
		}

		return trim(substr($fileContent, strpos($fileContent, '---') + strlen('---')));
	}

	/**
	 * Updates the statistical values (e.g. total number of books read).
	 */
	private function updateStatistics() : void {
		$allDates = array();

		foreach ($this->bookData as $key => $val) {
			if (preg_match('/.*.md/', $key)) {
				$this->bookData['TOTALREAD'] += count($val['dates']);
				
				$this->bookData['LASTYEARREAD'] += count(array_filter($val['dates'], function($d) {
					return time() - 60 * 60 * 24 * 365 <= $d; // year in seconds
				}));

				$allDates = array_merge($allDates, $val['dates']);
			}
		}

		$totalMonths = (time() - min($allDates)) / 60 / 60 / 24 / 30;
		$this->bookData['AVERAGEREAD'] = round($this->bookData['TOTALREAD'] / $totalMonths, 2);
	}
}

?>