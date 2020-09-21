$(function() {
	'use strict';

	// Restores the select element for sorting options
	window.location.search.substr(1).split("&").forEach(val => {
		if (val.includes('SORTVAL')) {
			$(`#sort option[value=${val.split('=')[1]}]`).prop('selected', true);
		}
	});
});