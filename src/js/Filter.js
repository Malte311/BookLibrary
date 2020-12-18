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
			$(`[id='${value}']`).addClass('badge-light').removeClass('badge-warning');
			array.splice(array.indexOf(value), 1);
		} else {
			$(`[id='${value}']`).addClass('badge-warning').removeClass('badge-light');
			array.push(value);
		}
	
		Filter.applyFilter();
	}

	/**
	 * Fetches the valid book note ids from the server and displays only those, i.e.,
	 * all other entries are filtered out.
	 */
	static async applyFilter() {
		let numBooks = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'numBooks'
		}));
		numBooks = Number.isNaN(parseInt(numBooks)) ? 0 : parseInt(numBooks);
		
		let searchVal = (new URLSearchParams(window.location.search)).get('SEARCHVAL');

		let data = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'filter',
			'filters': {
				[Filter.filterCats]: Filter.selectedCats,
				[Filter.filterType]: Filter.selectedTypes
			},
			'SEARCHVAL': searchVal !== null && searchVal !== undefined ? searchVal : ''
		}));

		data = Object.entries(JSON.parse(data)).map(e => e[1]);

		$('#numResults').html(`Displaying ${data.length} results`);
	
		for (let id = 0; id < numBooks; id++) {
			if (data.includes(id)) {
				$(`[id='${id}']`).show();
			} else {
				$(`[id='${id}']`).hide();
			}
		}

		Filter.displayBadges();
	}

	/**
	 * Displays badges for the currently selected types and categories.
	 */
	static displayBadges() {
		for (let filter of [Filter.filterCats, Filter.filterType]) {
			let array = filter === Filter.filterCats ? Filter.selectedCats : Filter.selectedTypes;

			if (!(array.length > 0)) {
				$(`#${filter}Badges`).html('<span class="badge badge-dark">All</span>');
			} else {
				$(`#${filter}Badges`).html('');
				array.forEach(val => {
					let str = `<span class="badge badge-warning mr-2">${val}</span>`;
					$(`#${filter}Badges`).append(str);
				});
			}
		}
	}
}
