'use strict';

/**
 * Class to apply user specified filters on the data, e.g. display only books of certain
 * categories or certain types (like ebook, paperback, ...).
 */
class Filter {
	/**
	 * Used when filtering categories.
	 */
	static filterCats = 'categories';
	
	/**
	 * Used when filtering types (ebook, paperback, etc.).
	 */
	static filterType = 'types';
	
	/**
	 * Used to store all filters for categories.
	 */
	static selectedCats = [];

	/**
	 * Used to store all filters for types.
	 */
	static selectedTypes = [];

	/**
	 * Applies filters of a given type to the book note overview.
	 * @param {string} type The type of the filters (e.g. types, categories).
	 * @param {string} value The value for that filter, e.g. type=ebook or category=programming.
	 */
	static filter(type, value) {
		let array = type === Filter.filterCats ? Filter.selectedCats : Filter.selectedTypes;

		if (array.includes(value)) {
			$(`#${value}`).addClass('badge-light').removeClass('badge-warning');
			array.splice(array.indexOf(value), 1);
		} else {
			$(`#${value}`).addClass('badge-warning').removeClass('badge-light');
			array.push(value);
		}
	
		Filter.applyFilter({[type]: array});
	}

	/**
	 * Fetches the valid book note ids from the server and displays only those, i.e.,
	 * all other entries are filtered out.
	 * @param {object} filter Object specifying what to filter for, e.g.
	 * {'types': ['ebook']} for displaying only ebooks or
	 * {'categories': ['programming', 'web']} for displaying books belonging to one
	 * (or more) of the given categories.
	 */
	static async applyFilter(filter) {
		let numBooks = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'numBooks'
		}));
		numBooks = Number.isNaN(parseInt(numBooks)) ? 0 : parseInt(numBooks);
	
		let data;
		if (filter[Object.keys(filter)[0]].length) {
			data = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
				'task': 'filter', 'filters': filter
			}));
			data = Object.entries(JSON.parse(data)).map(e => e[1]);
		} else {
			data = Array.from(Array(numBooks).keys());
		}
	
		for (let id = 0; id < numBooks; id++) {
			if (data.includes(id)) {
				$(`#${id}`).show();
			} else {
				$(`#${id}`).hide();
			}
		}
	}
}