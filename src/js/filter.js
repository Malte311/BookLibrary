'use strict';

var selectedTypes = [];
var selectedCats = [];

function filterType(type) {
	if (selectedTypes.includes(type)) {
		$(`#${type}`).addClass('badge-light').removeClass('badge-warning');
		selectedTypes.splice(selectedTypes.indexOf(type), 1);
	} else {
		$(`#${type}`).addClass('badge-warning').removeClass('badge-light');
		selectedTypes.push(type);
	}

	applyFilter({'types': selectedTypes});
}

window.location.search.substr(1).split("&").forEach(val => {
	if (val.includes('SORTVAL')) {
		$(`#sort option[value=${val.split('=')[1]}]`).prop('selected', true);
	}
});

async function applyFilter(filter) {
	let numBooks = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
		'task': 'numBooks'
	}));

	numBooks = Number.isNaN(parseInt(numBooks)) ? 0 : parseInt(numBooks);

	let data;

	if (filter['types'].length) {
		data = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'filter', 'filters': filter
		}));
	
		data = Object.entries(JSON.parse(data)).map(e => e[1]);
	} else {
		data = Array.from(Array(numBooks).keys());
	}

	for (let id = 0; id < parseInt(numBooks); id++) {
		if (data.includes(id)) {
			$(`#${id}`).show();
		} else {
			$(`#${id}`).hide();
		}
	}
}

// class Filter {
// 	constructor() {
// 		this.FILTER_TYPE = 'types';
// 		this.FILTER_CATS = 'categories';
// 	}
// }