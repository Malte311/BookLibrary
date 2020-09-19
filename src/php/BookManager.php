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
		$this->jsonReader = new JsonReader('statistics');
	}

	/**
	 * Returns the corresponding statistic for a given key.
	 * @param string $key The key for which the statistic should be returned.
	 * @return string The corresponding statistic to that key.
	 */
	public function getStats(string $key) : string {
		$value = $this->jsonReader->getValue([$key]);

		return isset($value) ? $value : '';
	}

	/**
	 * Returns available book data.
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