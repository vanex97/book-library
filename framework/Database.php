<?php

namespace Framework;

use PDO;

/**
 * Singleton class that connects to
 * MySQL database via PDO.
 */
class Database
{
    private const CONFIG_FILE = __DIR__ . '/../config.json';

    private ?PDO $pdo = null;
    private ?array $config;

    private static ?Database $instance = null;

    public static function getInstance(): Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @return PDO|null connecting PDO.
     */
    public function getPDO(): ?PDO
    {
        return $this->pdo;
    }

    private function __construct()
    {
        $this->config = $this->getConfig();
        if (!is_null($this->config)) {
            $this->pdo = $this->connect();
        }
    }

    /**
     * Get data from config file.
     * @return array|null Config DB associative array.
     */
    private function getConfig(): ?array
    {
        $configFile = self::CONFIG_FILE;
        if (!file_exists($configFile)) {
            return null;
        }
        $config = file_get_contents($configFile);
        $configData = json_decode($config, true);

        if (!key_exists('database', $configData)) {
            return null;
        }

        return $configData['database'];
    }

    /**
     * @return PDO|null connecting PDO or null.
     */
    private function connect(): ?PDO
    {
        $config = $this->config;
        try {
            return new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}",
                $config['username'],
                $config['password']
            );
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    /**
     * Returns used database name.
     * @return mixed|null
     */
    public function getDBName()
    {
        if (key_exists('dbname', $this->config)) {
            return $this->config['dbname'];
        }
        return null;
    }

    /**
     * @param $backupFileName
     */
    public function backupDB($backupFileName)
    {
        if ($this->config == null) {
            return;
        }

        $command = "/usr/local/bin/mysqldump "
            . '--column-statistics=0 '
            . "-u{$this->config['username']} "
            . "-p{$this->config['password']} "
            . "-h{$this->config['host']} "
            . "--port={$this->config['port']} "
            . "{$this->config['dbname']} "
            . ">> $backupFileName";

        exec($command);
    }
}
