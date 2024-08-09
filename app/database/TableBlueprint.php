<?php


namespace app\database;

class TableBlueprint
{
    private $columns = [];
    private $foreignKeys = [];
    private $currentColumn = null;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function increments($columnName)
    {
        $this->columns[$columnName] = 'INT AUTO_INCREMENT PRIMARY KEY';
        $this->currentColumn = $columnName;
        return $this;
    }

    public function string($columnName, $length = 255)
    {
        $this->columns[$columnName] = "VARCHAR($length)";
        $this->currentColumn = $columnName;
        return $this;
    }

    public function text($columnName)
    {
        $this->columns[$columnName] = "TEXT";
        $this->currentColumn = $columnName;
        return $this;
    }

    public function longText($columnName)
    {
        $this->columns[$columnName] = 'LONGTEXT';
        return $this;
    }

    public function tinyInteger($columnName)
    {
        $this->columns[$columnName] = 'TINYINT';
        return $this;
    }

    public function date($columnName)
    {
        $this->columns[$columnName] = 'DATE';
        return $this;
    }

    public function timestamps()
    {
        $this->columns['created_at'] = "TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns['updated_at'] = "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        $this->currentColumn = null;
        return $this;
    }

    public function nullable()
    {
        if ($this->currentColumn) {
            $this->columns[$this->currentColumn] .= " NULL";
        }
        return $this;
    }

    public function required()
    {
        if ($this->currentColumn) {
            $this->columns[$this->currentColumn] .= " NOT NULL";
        }
        return $this;
    }

    public function unique()
    {
        if ($this->currentColumn) {
            $this->columns[$this->currentColumn] .= " UNIQUE";
        }
        return $this;
    }

    public function default($value)
    {
        if ($this->currentColumn) {
            $this->columns[$this->currentColumn] .= " DEFAULT '$value'";
        }
        return $this;
    }

    public function comments($comment)
    {
        if ($this->currentColumn) {
            $escapedComment = str_replace("'", "''", $comment);
            $this->columns[$this->currentColumn] .= " COMMENT '$escapedComment'";
        }
        return $this;
    }

    public function foreign($columnName)
    {
        $this->columns[$columnName] = "INT";
        $this->currentColumn = $columnName;
        return $this;
    }

    public function references($tableName, $columnName)
    {
        if (!empty($this->currentColumn)) {
            // Add foreign key constraint to the current column
            $this->foreignKeys[$this->currentColumn] = [
                'columnName' => $this->currentColumn,
                'refTableName' => $tableName,
                'refColumnName' => $columnName,
            ];
            // Reset current column after adding the foreign key
            $this->currentColumn = null;
        }
        return $this;
    }

    public function cascade()
    {
        if (!empty($this->currentColumn)) {
            $this->foreignKeys[$this->currentColumn] .= " ON DELETE CASCADE";
        }
        return $this;
    }

    public function onDelete()
    {
        return $this;
    }

    public function hash()
    {
        if ($this->currentColumn) {
            $this->columns[$this->currentColumn] .= " /* Hash by default */";
        }
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getForeignKeys()
    {
        return $this->foreignKeys;
    }

    public function integer($columnName, $length = 11)
    {
        $this->columns[$columnName] = "INT($length)";
        return $this;
    }
}
