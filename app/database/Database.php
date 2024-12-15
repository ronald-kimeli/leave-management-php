<?php
namespace app\database;

use PDO;
use PDOException;

class Database {
    private $conn;
    private $config;
    private $maxRetries = 3;
    private $retryDelay = 2; // seconds for retry with exponential backoff

    public function __construct() {
        // Load database configuration
        $this->config = require(__DIR__ . '/../../src/database.php');

        // Attempt to initialize the connection
        $this->initializeConnection();
    }

    private function initializeConnection() {
        $databaseConfig = $this->config['database'];
        $dsn = "mysql:host={$databaseConfig['servername']};charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true, // Enable persistent connections
        ];

        for ($attempt = 0; $attempt < $this->maxRetries; $attempt++) {
            try {
                // Attempt to establish the connection
                $this->conn = new PDO($dsn, $databaseConfig['username'], $databaseConfig['password'], $options);

                // Check and create the database if it doesn't exist
                $this->createDatabaseIfNotExists($databaseConfig['database']);

                // Rebuild the DSN to include the database name
                $dsn = "mysql:host={$databaseConfig['servername']};dbname={$databaseConfig['database']};charset=utf8mb4";

                // Reconnect with the correct database
                $this->conn = new PDO($dsn, $databaseConfig['username'], $databaseConfig['password'], $options);

                return; // Connection successful, exit the retry loop
            } catch (PDOException $e) {
                if ($attempt < $this->maxRetries - 1 && $e->getCode() == '08004') {
                    // Retry on "Too many connections" error
                    echo "Error: Too many connections. Retrying in {$this->retryDelay} seconds...\n";
                    sleep($this->retryDelay);
                    $this->retryDelay *= 2; // Exponential backoff
                } else {
                    $this->handleDatabaseError($e);
                    return;
                }
            }
        }
    }

    private function handleDatabaseError(PDOException $e) {
        // Handle different database error types gracefully
        if ($e->getCode() == '08004') {
            echo "Error: Too many connections. Please try again later.\n";
        } else {
            // Log the error and show a generic message
            file_put_contents(__DIR__ . '/../../logs/database_error.log', $e->getMessage(), FILE_APPEND);
            echo "Database connection error. Please check the logs for more details.\n";
        }
        // Optionally redirect to a custom error page
        require_once __DIR__ . "/../../errors/dberror.php";
        die();
    }

    private function createDatabaseIfNotExists($databaseName) {
        $sql = "CREATE DATABASE IF NOT EXISTS $databaseName";

        try {
            // Check if the database already exists
            $stmt = $this->conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'");
            $databaseExists = $stmt->fetchColumn();

            if (!$databaseExists) {
                // Prompt the user to create the database
                $response = readline("Database '$databaseName' does not exist. Do you want to create it? (yes/no): ");
                if (empty($response) || strtolower($response) === 'yes' || strtolower($response) === 'y') {
                    $this->conn->exec($sql);
                    echo "Database '$databaseName' created successfully.\n";
                } elseif (strtolower($response) === 'no') {
                    echo "Migration aborted. Database '$databaseName' not created.\n";
                    exit();
                }
            }
        } catch (PDOException $e) {
            echo "Error checking or creating database: " . $e->getMessage() . "\n";
            exit();
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null; // Explicitly close the connection
    }
}