<?php

defined('BookLib') or die('Bad Request');

spl_autoload_register(function($class) {
	if (is_string($class) && preg_match('/^[A-Za-z0-9\-]+$/', $class) === 1) {
		$class_file = __DIR__ . '/' . $class . '.php';
		
		if (is_file($class_file)) {
			require_once($class_file);
		}
	}
});

?>