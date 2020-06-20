<?php

define('BookLib', 'ok');

error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

$login = new Login();

if ($login->isLoggedIn()) {
	
} else {
	echo "Authentication required!";
}

?>