<?php

define('BookLib', 'ok');

header('Content-Type: text/html; charset=utf-8');
error_reporting(!empty($_ENV['PROD']) && $_ENV['PROD'] == 'prod' ? 0 : E_ALL);

require_once(__DIR__ . '/php/autoload.php');

?>