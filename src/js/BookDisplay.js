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
		let content = await Promise.resolve($.get(`${SERVERURL}/ajax.php`, {
			'task': 'bookContent',
			'id': id
		}));

		console.log(content)

		$('#dialog').html(BookDisplay.converter.makeHtml(content));
		$('#dialog').dialog({
			closeOnEscape: true,
			draggable: true,
			minHeight: 0.5 * window.innerHeight,
			minWidth: 0.8 * window.innerWidth,
			modal: true,
			position: {at: 'top'},
			resizable: true,
			title: 'Some book'
		});
	}
}