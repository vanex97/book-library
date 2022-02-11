<?php

define('DB_TABLE_VERSION', 'version');
define('MIGRATIONS_DIR', __DIR__);

include_once realpath(__DIR__ . '/../vendor/autoload.php');

use Framework\Database;

/**
 * @param $pdo
 * @return array|false
 */
function getMigrationFiles($pdo) {
    // Get list with all sql files.
    $migrationFiles = glob(MIGRATIONS_DIR . '/*.sql');

    // Check last migration
    $sth = $pdo->prepare('SHOW TABLES LIKE :versionTable');
    $sth->execute([
        'versionTable' => DB_TABLE_VERSION
    ]);
    // Is a first migration
    if (!$sth->rowCount()) {
        return $migrationFiles;
    }

    // Get completed migrations.
    $sth = $pdo->prepare("SELECT name FROM " . DB_TABLE_VERSION);
    $sth->execute();
    $completedMigrations = [];
    while ($row = $sth->fetch()) {
        $filePath = __DIR__ . '/' . $row['name'];
        array_push($completedMigrations, $filePath);
    }

    return array_diff($migrationFiles, $completedMigrations);
}

/**
 * @param $pdo
 * @param $files
 * @return bool
 */
function migrate($pdo, $files) {
    foreach ($files as $file) {
        echo basename($file) . "\n";

        $query = file_get_contents($file);
        try {
            $pdo->exec($query);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            return false;
        }
        // Add complete migration to version table.
        $query = 'INSERT INTO ' . DB_TABLE_VERSION . ' (name) VALUES (:name)';
        $sth = $pdo->prepare($query);
        $sth->execute(['name' => basename($file)]);
    }
    return true;
}

$database = Database::getInstance();
$dbName = $database->getDBName();
$pdo = $database->getPDO();

$migrationFiles = getMigrationFiles($pdo);

echo "Migration start.\n";

$result = migrate($pdo, $migrationFiles);

if ($result) {
    echo "Migration successful";
}
else {
    echo "Migration failed.";
}
