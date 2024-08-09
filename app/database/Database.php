<?php
namespace app\database;

class Database {
    private $conn;

    public function __construct() {
        // Load database configuration
        $config = require(__DIR__ . '/../../src/database.php');
        $databaseConfig = $config['database'];
    
        // Establish the database connection
        $dsn = "mysql:host={$databaseConfig['servername']};charset=utf8mb4";
    
        $options = [
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
    
        try {
            // Attempt to connect to the MySQL server
            $this->conn = new \PDO($dsn, $databaseConfig['username'], $databaseConfig['password'], $options);
    
            // Check if the database exists; if not, create it
            $this->createDatabaseIfNotExists($databaseConfig['database']);
            
            // Rebuild the DSN with the specified database name
            $dsn = "mysql:host={$databaseConfig['servername']};dbname={$databaseConfig['database']};charset=utf8mb4";
    
            // Establish the connection with the specified database name
            $this->conn = new \PDO($dsn, $databaseConfig['username'], $databaseConfig['password'], $options);
        } catch (\PDOException $e) {
            // If connection fails, handle the error
            require_once __DIR__ . "/../../errors/dberror.php";
            die();
        }
    }
    
    public function createDatabaseIfNotExists($databaseName) {
        $sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
        
        // Check if the database already exists
        $stmt = $this->conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'");
        $databaseExists = $stmt->fetchColumn();
    
        if (!$databaseExists) {
            $response = readline("Database '$databaseName' does not exist. Do you want to create it? (yes/no): ");
            if (empty($response) || strtolower($response) === 'yes' || strtolower($response) === 'y') {
                $this->conn->exec($sql);
                echo "Database '$databaseName' created successfully.\n";
            } elseif (strtolower($response) === 'no') {
                echo "Migration aborted. Database '$databaseName' not created.\n";
                exit();
            }
        }
        // } else {
        //     echo "Database '$databaseName' already exists.\n";
        // }
    }
    
    public function getConnection() {
        return $this->conn;
    }
        
}
