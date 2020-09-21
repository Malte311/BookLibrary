$(function() {
	'use strict';

	// Restores the selected element for sorting options and the searched value (if existing)
	window.location.search.substr(1).split("&").forEach(val => {
		if (val.includes('SORTVAL')) {
			$(`#sort option[value=${val.split('=')[1]}]`).prop('selected', true);
		}

		if (val.includes('SEARCHVAL')) {
			$('#search').val(val.split('=')[1]);
		}
	});
});