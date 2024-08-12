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
        $blueprint = new TableBlueprint(); // Pass tableName to TableBlueprint constructor
        $callback($blueprint);
        $columns = $blueprint->getColumns();
        $foreignKeys = $blueprint->getForeignKeys(); // Get foreign keys
        $columnsSql = [];

        foreach ($columns as $name => $definition) {
            $columnsSql[] = "$name $definition";
        }

        // Add ENGINE and CHARSET to the CREATE TABLE statement
        $sql = "CREATE TABLE $tableName (" . implode(', ', $columnsSql) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->getConnection()->exec($sql);

        foreach ($foreignKeys as $key) {
            $columnName = $key['columnName'];
            $refTableName = $key['refTableName'];
            $refColumnName = $key['refColumnName'];

            // Generate a unique constraint name
            $constraintName = $this->generateConstraintName($tableName, $columnName);

            // Check if the foreign key constraint already exists
            $constraintExists = $this->checkConstraintExists($tableName, $constraintName);

            // If the constraint exists, drop it before adding
            if ($constraintExists) {
                $dropSql = "ALTER TABLE $tableName DROP FOREIGN KEY $constraintName";
                $this->db->getConnection()->exec($dropSql);
            }

            // Add the foreign key constraint with the unique name
            $constraintSql = "ALTER TABLE $tableName ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName)";
            $this->db->getConnection()->exec($constraintSql);
        }
    }

    public function dropTable($tableName)
    {
        // Disable foreign key checks
        $sql = "SET FOREIGN_KEY_CHECKS=0";
        $this->db->getConnection()->exec($sql);
    
        // Drop the table if it exists
        $sql = "DROP TABLE IF EXISTS $tableName";
        $this->db->getConnection()->exec($sql);
    
        // Enable foreign key checks
        $sql = "SET FOREIGN_KEY_CHECKS=1";
        $this->db->getConnection()->exec($sql);
    
        echo "Table $tableName dropped successfully.\n";
    }

    public function tableExists($tableName)
    {
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = $this->db->getConnection()->query($sql);
        return $result->rowCount() > 0;
    }

    public function executeTable($tableName, callable $callback)
    {
        try {
            if ($this->tableExists($tableName)) {
                echo "Table '$tableName' already exists.\n";
                $response = readline("Do you want to drop the existing table and proceed with migration? (yes/no): ");
                if (empty($response) || strtolower($response) === 'yes' || strtolower($response) === 'y') {
                    $this->dropTable($tableName);
                    $this->createTable($tableName, $callback);
                    echo "Migration for table '$tableName' successful.\n";
                } else {
                    echo "Migration for table '$tableName' skipped.\n";
                }
            } else {
                $this->createTable($tableName, $callback);
                echo "Migration for table '$tableName' successful.\n";
            }
        } catch (\PDOException $e) {
            throw new \Exception("Migration failed for table '$tableName': " . $e->getMessage());
        }
    }

    public function generateConstraintName($tableName, $columnName)
    {
        // Generate a unique constraint name based on table and column names
        return "fk_$columnName" . "_" . $tableName;
    }

    // Function to check if the foreign key constraint exists
    public function checkConstraintExists($tableName, $constraintName)
    {
        $sql = "SELECT COUNT(*) AS count FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = '$tableName' AND CONSTRAINT_NAME = '$constraintName' AND CONSTRAINT_TYPE = 'FOREIGN KEY'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch();
        return $row['count'] > 0;
    }

    // Additional method to get SQL for foreign key
    public function generateForeignKeySQL($tableName, $columnName, $refTableName, $refColumnName)
    {
        $constraintName = $this->generateConstraintName($tableName, $columnName);
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName)";
        return $sql;
    }
}

