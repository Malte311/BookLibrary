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
	 * @param array $filters Filters to filter the data (e.g. display only ebooks).
	 * @return array The available book note data.
	 */
	public function getBookData(array $filters = array()) : array {
		$data = $this->filterBookData(array_filter($this->jsonReader->getArray(), function($e) {
			return strpos($e, '.md') !== false;
		}, ARRAY_FILTER_USE_KEY), $filters);

		$sort = (isset($_GET['SORTVAL']) && !empty($_GET['SORTVAL'])) ? $_GET['SORTVAL'] : 'newest';

		return $this->sortBookData($data, $sort);
	}

	/**
	 * Returns the number of book note files.
	 * @return int The number of book note files.
	 */
	public function getBookCount() : int {
		return $this->jsonReader->getValue(['NUMBOOKS']);
	}

	/**
	 * Returns the content of a given book note.
	 * @param int $id The id of the book note for which the content should be returned.
	 * @return string The content of that book note.
	 */
	public function getBookContent(int $id) : string {
		// $data = array_filter(array_filter($this->jsonReader->getArray(), function($e) {
		// 	return strpos($e, '.md') !== false;
		// }, ARRAY_FILTER_USE_KEY), function($e) use($id) {
		// 	return $e['id'] === $id;
		// });

		// return $data;

		// return array($data['title'] => $data['content']);

		return $this->jsonReader->getValue([$id, 'content']);
	}

	/**
	 * Checks whether a given book note file has a cover.
	 * @param string $filename The name of the book note file.
	 * @return bool True if a cover exists, else false.
	 */
	public function hasCover(string $filename) : bool {
		return file_exists('./data/covers/' . str_replace('.md', '.jpg', $filename));
	}

	/**
	 * Filters the data if filters are set (e.g. display only eBooks or only a specific category).
	 * @param array $data The data to be filtered.
	 * @param array $filters Filters to be applied to the data (e.g. {'types': ['ebook']} to display
	 * only ebooks).
	 * @return array The filtered data.
	 */
	private function filterBookData(array $data, array $filters) : array {
		if (isset($_GET['SEARCHVAL']) && !empty($_GET['SEARCHVAL'])) {
			$data = array_filter($data, function($e) {
				return stripos($e['title'], $_GET['SEARCHVAL']) !== false
					|| stripos($e['author'], $_GET['SEARCHVAL']) !== false
					|| stripos($e['content'], $_GET['SEARCHVAL']) !== false;
			});
		}

		foreach (array('categories', 'types') as $index) {
			if (isset($filters[$index]) && is_array($filters[$index])) {
				$data = array_filter($data, function($e) use($index, $filters) {
					foreach ($filters[$index] as $type) {
						if (!in_array($type, $e[$index])) {
							return false;
						}
					}
					return true;
				});
			}
		}

		return $data;
	}

	/**
	 * Sorts the data by a given metric.
	 * @param array $data The data to be sorted.
	 * @param string $sortType The metric for sorting.
	 * Can be 'newest', 'alphabetical' or 'mostread'.
	 * @return array The sorted data.
	 */
	private function sortBookData(array $data, string $sortType) : array {
		switch ($sortType) {
			case 'newest':
				array_multisort(array_map(function($e) {
					return max($e);
				}, array_column($data, 'dates')), SORT_DESC, $data);
				break;
			case 'alphabetical':
				array_multisort(array_column($data, 'title'), SORT_ASC, $data);
				break;
			case 'mostread':
				array_multisort(array_map(function($e) {
					return count($e);
				}, array_column($data, 'dates')), SORT_DESC, $data);
				break;
			default:
				array_multisort(array_column($data, 'title'), SORT_ASC, $data);
				break;
		}

		return $data;
	}
}

?>