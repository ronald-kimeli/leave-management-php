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
        $blueprint = new TableBlueprint();
        $callback($blueprint);
        $columns = $blueprint->getColumns();
        $foreignKeys = $blueprint->getForeignKeys();
        $columnsSql = [];

        foreach ($columns as $name => $definition) {
            $columnsSql[] = "$name $definition";
        }

        $sql = "CREATE TABLE $tableName (" . implode(', ', $columnsSql) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->getConnection()->exec($sql);

        foreach ($foreignKeys as $key) {
            $columnName = $key['columnName'];
            $refTableName = $key['refTableName'];
            $refColumnName = $key['refColumnName'];

            $constraintName = $this->generateConstraintName($tableName, $columnName);
            $constraintExists = $this->checkConstraintExists($tableName, $constraintName);

            if ($constraintExists) {
                $dropSql = "ALTER TABLE $tableName DROP FOREIGN KEY $constraintName";
                $this->db->getConnection()->exec($dropSql);
            }

            $constraintSql = "ALTER TABLE $tableName ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName)";
            $this->db->getConnection()->exec($constraintSql);
        }
    }

    public function dropTable($tableName)
    {
        $sql = "SET FOREIGN_KEY_CHECKS=0";
        $this->db->getConnection()->exec($sql);

        $sql = "DROP TABLE IF EXISTS $tableName";
        $this->db->getConnection()->exec($sql);

        $sql = "SET FOREIGN_KEY_CHECKS=1";
        $this->db->getConnection()->exec($sql);

        // echo "\033[1;31mTable $tableName dropped successfully.\033[0m\n"; // Red for dropped tables
        echo "\033[1;32mTable '$tableName' dropped successfully.\033[0m\n"; // Green for dropped success
    }

    public function tableExists($tableName)
    {
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = $this->db->getConnection()->query($sql);
        return $result->rowCount() > 0;
    }

    public function current_time() {
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
    
    
    

    public function generateConstraintName($tableName, $columnName)
    {
        return "fk_$columnName" . "_" . $tableName;
    }

    public function checkConstraintExists($tableName, $constraintName)
    {
        $sql = "SELECT COUNT(*) AS count FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = '$tableName' AND CONSTRAINT_NAME = '$constraintName' AND CONSTRAINT_TYPE = 'FOREIGN KEY'";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch();
        return $row['count'] > 0;
    }

    public function generateForeignKeySQL($tableName, $columnName, $refTableName, $refColumnName)
    {
        $constraintName = $this->generateConstraintName($tableName, $columnName);
        $sql = "ALTER TABLE $tableName ADD CONSTRAINT $constraintName FOREIGN KEY ($columnName) REFERENCES $refTableName($refColumnName)";
        return $sql;
    }
}
