'use strict';

/**
 * Allows to view book note contents.
 */
class BookDisplay {

	/**
	 * Converter for markdown files.
	 */
	static converter = new showdown.Converter();

	/**
	 * Displays the content of a given book note.
	 * @param {string} id The id of the book note which should be displayed.
	 */
	static async viewContent(id) {
		let dataObj = JSON.parse(await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'bookContent',
			'id': id
		})));

		let key = Object.keys(dataObj)[0];
		$('#dialog').load(`${SERVERURL}/templates/noteView.html`, () => {
			$('#noteDates').html(dataObj[key]['dates'].map(e => {
				return BookDisplay.strDate(new Date(e * 1000));
			}).join(', '));

			$('#noteTypes').html(dataObj[key]['types'].map(e => {
				return `<span class="badge badge-warning ml-1">${e}</span>`;
			}).join(', '));

			$('#noteCats').html(dataObj[key]['categories'].map(e => {
				return `<span class="badge badge-warning ml-1">${e}</span>`;
			}).join(', '));

			$('#noteContent').html(BookDisplay.converter.makeHtml(dataObj[key]['content']));
		});
		
		BookDisplay.createDialog(`${dataObj[key]['title']} -- ${dataObj[key]['author']}`);
	}

	/**
	 * Creates a dialog with a given title. Text has to be added additionally.
	 * @param {string} title The title for the dialog.
	 */
	static createDialog(title) {
		$('#dialog').dialog({
			close: function() {
				$('body').css({overflow: 'inherit'});
				$('#main, nav').css({'opacity': 1});
			},
			closeOnEscape: true,
			draggable: true,
			minHeight: 0.5 * window.innerHeight,
			minWidth: 0.5 * window.innerWidth,
			modal: true,
			position: {at: 'top'},
			resizable: true,
			title: title
		});

		$('body').css({overflow: 'hidden'});
		$('#main, nav').css({'opacity': 0.2});
	}

	/**
	 * Converts a date object to a readable string.
	 * @param {Date} date The date object to convert.
	 * @return string The date formatted as a string.
	 */
	static strDate(date) {
		return (date.getDate() < 10 ? '0' + date.getDate().toString() : date.getDate().toString())
			+ '.' + ((date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1).toString() :
			(date.getMonth() + 1).toString()) + '.' + date.getFullYear().toString();
	}
}