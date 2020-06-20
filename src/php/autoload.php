<?php

defined('BookLib') or die('Bad Request');

spl_autoload_register(function($class) {
	if (is_string($class) && preg_match('/^[A-Za-z0-9\-]+$/', $class) === 1) {
		$classFile = __DIR__ . '/' . $class . '.php';
		
		if (is_file($classFile)) {
			require_once($classFile);
		}
	}
});

JsonReader::changePath(__DIR__ . '/../data/');

?>