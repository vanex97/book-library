<?php
include_once realpath(__DIR__ . '/../vendor/autoload.php');

use Framework\Database;

$backupFilePath = realpath(__DIR__ . '/../backup');
$backupFileName = 'backup_' . date("Y-m-d_H:i:s") . '.sql';

$backupFile = $backupFilePath . '/' . $backupFileName;

Database::getInstance()->backupDB($backupFile);
