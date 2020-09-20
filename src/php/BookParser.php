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
	}

	/**
	 * Scans the data/books/ directory for available books and parses their information.
	 * The information is stored in separate json files, available in the data/ directory.
	 * @param string $dir The directory to scan.
	 */
	public function scanDirectory(string $dir = __DIR__ . '/../data/books') : void {
		foreach (scandir($dir) as $file) {
			$filename = "{$dir}/{$file}";

			if (is_file($filename) && $this->isMarkdownFile($filename)) {
				$this->parseFile($filename);
			}
		}
	}

	/**
	 * Parses a given markdown file and saves the book information.
	 * @param string $file The file to parse.
	 */
	private function parseFile(string $file) : void {
		// TODO
	}

	/**
	 * Checks whether a given file is a markdown file.
	 * @param string $file The file to check.
	 * @return bool True if the file is a markdown file, else false.
	 */
	private function isMarkdownFile(string $file) : bool {
		return pathinfo($file)['extension'] === 'md';
	}
}

?>