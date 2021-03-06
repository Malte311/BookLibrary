<?php

define('BookLib', 'ok');

error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

$login = new Login();

if ($login->isLoggedIn()) {
	switch ($_GET['task']) {
		case 'bookContent':
			$bookId = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : -1;
			echo json_encode((new BookManager())->getBookContent(intval($bookId)));
			break;
		case 'filter':
			$isValidData = isset($_GET['filters']) && is_array($_GET['filters']);
			echo json_encode(array_map(function($e) {
				return $e['id'];
			}, (new BookManager())->getBookData($isValidData ? $_GET['filters'] : array())));
			break;
		case 'numBooks':
			echo json_encode((new BookManager())->getBookCount());
			break;
		default:
			echo json_encode(array('error' => 'Invalid request'));
			break;
	}
} else {
	echo json_encode(array('error' => 'Authentication required'));
}

?>