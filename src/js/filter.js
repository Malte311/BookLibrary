'use strict';

var selectedTypes = [];
var selectedCats = [];

var maxId = 0;

$(function() {
	loadBooks();
});

async function loadBooks() {
	maxId = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {'task': 'maxId'}));

	displayBooks();
}

function displayBooks() {
	for (let id = 0; id <= maxId; id++) {
		$(`#${id}`).show();
	}
}

function filterType(type) {
	if (selectedTypes.includes(type)) {
		$(`#${type}`).addClass('badge-light').removeClass('badge-warning');
		selectedTypes.splice(selectedTypes.indexOf(type), 1);
	} else {
		$(`#${type}`).addClass('badge-warning').removeClass('badge-light');
		selectedTypes.push(type);
	}

	displayBooks();
}