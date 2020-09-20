<?php

define('BookLib', 'ok');

error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

$login = new Login();

if ($login->isLoggedIn()) {
	switch ($_GET['task']) {
		default:
			echo json_encode(array('error' => 'Invalid request'));
			break;
	}
} else {
	echo json_encode(array('error' => 'Authentication required'));
}

?>