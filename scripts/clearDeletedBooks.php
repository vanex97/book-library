<?php
include_once realpath(__DIR__ . '/../vendor/autoload.php');

use Framework\Database;

$pdo = Database::getInstance()->getPDO();
$pdo->query('DELETE FROM books WHERE is_deleted=1');