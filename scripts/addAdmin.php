<?php

include_once realpath(__DIR__ . '/../vendor/autoload.php');

use Framework\Database;

$login = readline('Enter login:');
$password = readline('Enter password:');

if (!$login && !$password) {
    echo 'Incorrect data';
    die();
}

$pdo = Database::getInstance()->getPDO();
if ($pdo == null) die();

$sth = $pdo->prepare('
    INSERT INTO admin (login, password) VALUES (:login, :password)
');

try {
    $sth->execute([
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    echo 'User added';
} catch (Exception) {
    echo 'Oops, something went wrong. Check the database.';
}