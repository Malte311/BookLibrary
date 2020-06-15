<?php

define('BookLib', 'ok');

header('Content-Type: text/html; charset=utf-8');
error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

$login = new Login();

if ($login->isLoggedIn()) {
	echo "Some fancy text.";
} else {
	echo "Nope!";
}

?>