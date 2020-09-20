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
		foreach (scandir($dir) as $index => $file) {
			$filename = "{$dir}/{$file}";

			if (is_file($filename) && $this->isMarkdownFile($filename)) {
				$this->parseFile($filename);
				$this->jsonReader->setValue([null], $this->bookData[$file]);
			}
		}
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
	function parseTitle(string $fileContent) : string {
		
	}

	/**
	 * Extracts the dates (when the book was read) from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding dates when the book was read.
	 */
	function parseDates(string $fileContent) : array {
		
	}

	/**
	 * Extracts the types (in which form the book was read, e.g. paperback or ebook)
	 * from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding types in which form the book was read.
	 */
	function parseTypes(string $fileContent) : array {
		
	}

	/**
	 * Extracts the categories from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return array The corresponding categories.
	 */
	function parseCategories(string $fileContent) : array {
		
	}

	/**
	 * Extracts the raw content from a given book note file.
	 * @param string $fileContent The content of a book note file.
	 * @return string The corresponding raw content (without title, dates, types, etc.).
	 */
	function parseContent(string $fileContent) : string {
		
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