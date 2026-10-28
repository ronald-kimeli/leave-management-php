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

        $columnsSql = array_map(
            fn($name, $definition) => "$name $definition",
            array_keys($blueprint->getColumns()),
            $blueprint->getColumns()
        );

        $sql = "CREATE TABLE $tableName (" . implode(', ', $columnsSql) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->getConnection()->exec($sql);

        try {
            foreach ($blueprint->getForeignKeys() as $key) {
                $this->addForeignKeyConstraint($tableName, $key);
            }
        } catch (\PDOException $e) {
            // The table was created a moment ago by this run, so it holds no data
            $this->dropTable($tableName);
            throw $e;
        }
    }

    public function addColumns($tableName, callable $callback)
    {
        $blueprint = new TableBlueprint();
        $callback($blueprint);

        foreach ($blueprint->getColumns() as $name => $definition) {
            if ($this->columnExists($tableName, $name)) {
                echo "\033[1;33mColumn $tableName.$name already exists, skipped.\033[0m\n";
                continue;
            }
            $this->db->getConnection()->exec("ALTER TABLE $tableName ADD COLUMN $name $definition");
        }

        foreach ($blueprint->getForeignKeys() as $key) {
            $this->addForeignKeyConstraint($tableName, $key);
        }
    }

    public function columnExists($tableName, $columnName)
    {
        $stmt = $this->db->getConnection()->prepare(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?"
        );
        $stmt->execute([$tableName, $columnName]);
        return $stmt->fetchColumn() > 0;
    }

    private function addForeignKeyConstraint($tableName, $key)
    {
        $columnName = $key['columnName'];
        $refTableName = $key['refTableName'];
        $refColumnName = $key['refColumnName'];

        // Generate constraint name
        $constraintName = $this->generateConstraintName($tableName, $columnName);

        // Add the foreign key constraint with ON DELETE CASCADE
        $sql = "ALTER TABLE $tableName 
                ADD CONSTRAINT $constraintName 
                FOREIGN KEY ($columnName) 
                REFERENCES $refTableName($refColumnName) 
                ON DELETE CASCADE";
        $this->db->getConnection()->exec($sql);
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

    private function ensureMigrationsTable()
    {
        $this->db->getConnection()->exec(
            "CREATE TABLE IF NOT EXISTS migrations (
                id VARCHAR(191) PRIMARY KEY,
                ran_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }

    private function ranMigrations()
    {
        return $this->db->getConnection()->query("SELECT id FROM migrations")->fetchAll(PDO::FETCH_COLUMN);
    }

    private function recordMigration($id)
    {
        $this->db->getConnection()->prepare("INSERT INTO migrations (id) VALUES (?)")->execute([$id]);
    }

    /**
     * Drops every table in the database, including the migrations log.
     */
    public function fresh()
    {
        $pdo = $this->db->getConnection();
        $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
        foreach ($pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN) as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "\033[1;32mTable '$table' dropped.\033[0m\n";
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    }

    /**
     * Runs every migration not yet recorded in the migrations table, in array order.
     * Each migration: ['id' => ..., 'type' => 'create'|'add_columns', 'table' => ..., 'up' => callable].
     * A 'create' migration whose table already exists (database that predates the log) is
     * recorded without touching the table.
     */
    public function run(array $migrations, $onlyTable = null)
    {
        $this->ensureMigrationsTable();
        $ran = $this->ranMigrations();
        $pending = 0;

        foreach ($migrations as $m) {
            if (in_array($m['id'], $ran, true) || ($onlyTable && $m['table'] !== $onlyTable)) {
                continue;
            }
            $pending++;
            $startTime = microtime(true);

            try {
                if ($m['type'] === 'create' && $this->tableExists($m['table'])) {
                    echo "\033[1;33mTable {$m['table']} already exists, recorded {$m['id']} without changes.\033[0m\n";
                } elseif ($m['type'] === 'create') {
                    $this->createTable($m['table'], $m['up']);
                } else {
                    $this->addColumns($m['table'], $m['up']);
                }
                $this->recordMigration($m['id']);
                $duration = round(microtime(true) - $startTime);
                echo "\033[1;32m[\033[1;34m{$m['id']} \033[0;36m" . $this->current_time() . "\033[1;32m] \033[1;37mSuccess! -----> {$duration}s\033[0m\n\n";
            } catch (\PDOException $e) {
                echo "\033[1;31mMigration {$m['id']} failed: " . $e->getMessage() . "\033[0m\n\n";
                return;
            }
        }

        if ($pending === 0) {
            echo "Nothing to migrate.\n";
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