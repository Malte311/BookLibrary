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
}

window.location.search.substr(1).split("&").forEach(val => {
	if (val.includes('SORTVAL')) {
		$(`#sort option[value=${val.split('=')[1]}]`).prop('selected', true);
	}
})

$('#sort').change(() => {
	$.get(`${SERVERURL}/index.php`, {'SORTVAL': $('#sort').val()});
});