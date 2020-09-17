<?php

define('BookLib', 'ok');

require_once(__DIR__ . '/php/autoload.php');

$jsonReader = new JSONReader('user');

switch ($argv[1]) {
	case 'add':
		addUser();
		break;
	case 'edit':
		$userId = readline('ID: ');
		editUser($userId);
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
		$isValidName = Utilities::isValidUserName($userData['userName']);
		
		if (!$isAvailable) {
			echo 'Username already taken.' . PHP_EOL;
		} else if (!$isValidName) {
			echo 'Invalid username.' . PHP_EOL;
		}
	} while (!$isValidName || !$isAvailable);

	$userData['pwd'] = readPwd($userData['salt']);
	$userData['userId'] = createId();

	$jsonReader->setValue([null], $userData);
	echo "Created user {$userData['userName']} successfully.";
}

/**
 * Reads a password from the console and returns a hash of it (including salt).
 * @param string $salt A salt for the password.
 * @return string A hash of password and salt.
 */
function readPwd(string $salt) : string {
	$pwd = '';

	system('stty -echo');
	do {
		echo 'New password: ';
		$pwd = rtrim(fgets(STDIN), PHP_EOL);
		echo 'Password (again): ';
		$pwdAgain = rtrim(fgets(STDIN), PHP_EOL);

		if ($pwd !== $pwdAgain) {
			echo 'Passwords are not matching.' . PHP_EOL;
		}
	} while ($pwd !== $pwdAgain);
	system('stty echo');

	return hash('sha512', $pwd . $salt);
}

/**
 * Creates an identifier for a new user.
 * @return int The new id.
 */
function createId() : int {
	global $jsonReader;

	$newId = -1;

	foreach ($jsonReader->getArray() as $userId => $userData) {
		$newId = $userId;
	}

	return $newId + 1;
}

/**
 * Changes the password of a user, given by id.
 * @param string $userId The id of the user for whom the password should be changed.
 */
function editUser(string $userId) : void {
	global $jsonReader;

	$newSalt = Utilities::randomString(50, Utilities::DEFAULT_ALPHABET);
	$newPwd = readPwd($newSalt);

	if (readline("Really change the password for user with id {$userId}? (y/n)") === 'y') {
		$jsonReader->setValue([$userId, 'pwd'], $newPwd);
		$jsonReader->setValue([$userId, 'salt'], $newSalt);
		echo 'Changed password successfully.';
	}
}

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