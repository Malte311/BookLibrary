<?php

defined('BookLib') or die('Bad Request');

/**
 * Handles book statistics.
 */
class BookManager {
	/**
	 * JsonReader object to deal with json files.
	 */
	private JsonReader $jsonReader;
	
	/**
	 * Initializes the json reader object.
	 */
	public function __construct() {
		$this->jsonReader = new JsonReader('bookData');
	}

	/**
	 * Returns the statistical information (how many books read so far, etc.).
	 * @return array The statistical information.
	 */
	public function getStats() : array {
		$stats = array();
		foreach (Utilities::STATISTICS as $key) {
			$stats[$key] = $this->jsonReader->getValue([$key]);
		}

		return $stats;
	}

	/**
	 * Returns all types which are currently in use.
	 * @return array All types which are currently in use.
	 */
	public function getTypes() : array {
		return $this->jsonReader->getValue(['ALLTYPES']);
	}

	/**
	 * Returns all categories which are currently in use.
	 * @return array All categories which are currently in use.
	 */
	public function getCategories() : array {
		return $this->jsonReader->getValue(['ALLCATS']);
	}

	/**
	 * Returns available book note data.
	 * @return array The available book note data.
	 */
	public function getBookData() : array {
		return array_filter($this->jsonReader->getArray(), function($e) {
			return strpos($e, '.md') !== false;
		}, ARRAY_FILTER_USE_KEY);
	}

	/**
	 * Checks whether a given book note file has a cover.
	 * @param string $filename The name of the book note file.
	 * @return bool True if a cover exists, else false.
	 */
	public function hasCover(string $filename) : bool {
		return file_exists('./data/covers/' . str_replace('.md', '.jpg', $filename));
	}
}

?>