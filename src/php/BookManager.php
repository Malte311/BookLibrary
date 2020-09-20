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
	 * Returns available book note data.
	 * @return array The available book note data.
	 */
	public function getBookData() : array {		
		return array(
			"book1" => "C# lernen",
			"book2" => "Programmieren lernen mit Java",
			"book3" => "Programmierung sicherer Systeme mit Rust",
		);
	}
}

?>