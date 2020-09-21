<?php

define('BookLib', 'ok');

error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

$login = new Login();

if ($login->isLoggedIn()) {
	switch ($_GET['task']) {
		case 'filter':
			$isValidData = isset($_GET['filters']) && is_array($_GET['filters']);
			echo json_encode($isValidData ? array_map(function($e) {
				return $e['id'];
			}, (new BookManager())->getBookData($_GET['filters'])) : array());
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