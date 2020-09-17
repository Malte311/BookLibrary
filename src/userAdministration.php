<?php

define('BookLib', 'ok');

require_once(__DIR__ . '/php/autoload.php');

$jsonReader = new JSONReader('user');

switch ($argv[1]) {
	case 'add':
		addUser();
		break;
	case 'edit':
		break;
	case 'delete':
		$userId = readline('ID: ');
		deleteUser($userId);
		break;
	case 'list':
		listUser();
		break;
	default:
		echo 'How to use:' . PHP_EOL;
		echo "\tphp {$argv[0]} add | edit | delete | list";
		break;
}

/**
 * Adds a new user to the set of available users.
 */
function addUser() : void {
	global $jsonReader;

	$userData = array(
		'salt' => Utilities::randomString(50, Utilities::DEFAULT_ALPHABET),
		'codes' => array()
	);

	do {
		$userData['userName'] = readline('Username: ');
		$isAvailable = $jsonReader->searchValue([], $userData['userName'], 'userName') === false;
		
		if (!$isAvailable) {
			echo 'Username already taken.' . PHP_EOL;
		}
	} while (!Utilities::isValidUserName($userData['userName']) || !$isAvailable);

	
}

function editUser() : void {}

/**
 * Deletes a user, given by id.
 * @param string $userId The id of the user who should get deleted.
 */
function deleteUser(string $userId) : void {
	global $jsonReader;

	if ($jsonReader->isValue([$userId]) && readline('ID ' . $userId . ' löschen? (y/n)') === 'y') {
		$jsonReader->setValue([$userId], null);
		echo "Deleted user with id {$userId} successfully.";
	}
}

/**
 * Displays a list of all currently available users.
 */
function listUser() : void {
	global $jsonReader;

	foreach ($jsonReader->getArray() as $userId => $userData) {
		echo "ID: {$userData['userId']}" . PHP_EOL;
		echo "Name: {$userData['userName']}" . PHP_EOL;
	}
}

?>