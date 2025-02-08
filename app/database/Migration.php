<?php
namespace app\database;

use PDO;
use app\database\Database;
use app\database\TableBlueprint;

class Migration
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createTable($tableName, callable $callback)
    {
        try {
            $blueprint = new TableBlueprint();
            $callback($blueprint);

            $columnsSql = array_map(
                fn($name, $definition) => "$name $definition",
                array_keys($blueprint->getColumns()),
                $blueprint->getColumns()
            );

            $sql = "CREATE TABLE $tableName (" . implode(', ', $columnsSql) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $this->db->getConnection()->exec($sql);

            foreach ($blueprint->getForeignKeys() as $key) {
                $this->addForeignKeyConstraint($tableName, $key);
            }
        } catch (\PDOException $e) {
            echo "\033[1;31mError creating table '$tableName': " . $e->getMessage() . "\033[0m\n";
        }
    }

    private function addForeignKeyConstraint($tableName, $key)
    {
        $columnName = $key['columnName'];
        $refTableName = $key['refTableName'];
        $refColumnName = $key['refColumnName'];

        // Generate constraint name
        $constraintName = $this->generateConstraintName($tableName, $columnName);

        try {
            // Add the foreign key constraint with ON DELETE CASCADE
            $sql = "ALTER TABLE $tableName 
                    ADD CONSTRAINT $constraintName 
                    FOREIGN KEY ($columnName) 
                    REFERENCES $refTableName($refColumnName) 
                    ON DELETE CASCADE";
            $this->db->getConnection()->exec($sql);
        } catch (\PDOException $e) {
            echo "\033[1;31mError adding foreign key constraint to '$tableName': " . $e->getMessage() . "\033[0m\n";
        }
    }

    public function dropTable($tableName)
    {
        // Disable foreign key checks to avoid constraint errors
        $this->db->getConnection()->exec("SET FOREIGN_KEY_CHECKS=0");

        // Drop the table
        $this->db->getConnection()->exec("DROP TABLE IF EXISTS $tableName");

        // Re-enable foreign key checks
        $this->db->getConnection()->exec("SET FOREIGN_KEY_CHECKS=1");

        echo "\033[1;32mTable '$tableName' dropped successfully.\033[0m\n";
    }

    public function tableExists($tableName)
    {
        $result = $this->db->getConnection()->query("SHOW TABLES LIKE '$tableName'");
        return $result->rowCount() > 0;
    }

    public function current_time()
    {
        date_default_timezone_set("Africa/Nairobi");
        return date("m/d/Y h:i:s a", time());
    }

    public function executeTable($tableName, callable $callback)
    {
        try {
            $startTime = microtime(true); // Start timing

            if ($this->tableExists($tableName)) {
                echo "\033[1;31mTable $tableName already exists.\033[0m\n"; // Red for existing table
                $response = readline("Do you want to drop the existing table and proceed with migration? (yes/no): ");
                if (empty($response) || strtolower($response) === 'yes' || strtolower($response) === 'y') {
                    $this->dropTable($tableName);
                    $this->createTable($tableName, $callback);
                    $duration = round(microtime(true) - $startTime); // Calculate duration
                    echo "\033[1;32m[\033[1;34m$tableName table migration \033[0;36m" . $this->current_time() . "\033[1;32m] \033[1;37mSuccess! -----> {$duration}s\033[0m\n\n"; // Green for success, with spacing
                } else {
                    echo "\033[1;33mMigration for table $tableName skipped.\033[0m\n\n"; // Yellow for skipped, with spacing
                }
            } else {
                $this->createTable($tableName, $callback);
                $duration = round(microtime(true) - $startTime); // Calculate duration
                echo "\033[1;32mMigration for table '$tableName' successful! -----> {$duration}s\033[0m\n\n\n"; // Green for success, with spacing
            }
        } catch (\PDOException $e) {
            echo "\033[1;31mMigration failed for table '$tableName': " . $e->getMessage() . "\033[0m\n\n"; // Red for error, with spacing
        }
    }

    // Generates the constraint name for the foreign key
    private function generateConstraintName($tableName, $columnName)
    {
        return $tableName . "_" . $columnName . "_foreign";
    }

    // Check if the foreign key constraint exists in the database
    private function checkConstraintExists($tableName, $constraintName)
    {
        $sql = "SELECT COUNT(*) AS count from INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = '$tableName' AND CONSTRAINT_NAME = '$constraintName' AND CONSTRAINT_TYPE = 'FOREIGN KEY'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch();
        return $row['count'] > 0;
    }

    // Generate the SQL for the foreign key, including CASCADE actions
    private function generateForeignKeySQL($tableName, $columnName, $refTableName, $refColumnName)
    {
        $constraintName = $this->generateConstraintName($tableName, $columnName);

        // Generate the foreign key SQL with CASCADE on DELETE and UPDATE
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName) ON DELETE CASCADE ON UPDATE CASCADE";

        return $sql;
    }

}