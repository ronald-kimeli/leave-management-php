<?php

namespace app\models;

use PDO;
use app\database\Database;

class BaseModel
{
    protected $db;
    protected $tableName;
    protected $attributes = [];
    protected $guarded = ['id'];
    protected $where = '';
    protected $whereLike = '';
    protected $params = [];
    protected $orderBy = '';
    protected $limit = '';
    protected $offset = '';
    protected $eagerLoad = [];

    public function __construct()
    {
        $this->db = new Database();
    }

    public static function model()
    {
        return new static();
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = new static();
        return call_user_func_array([$instance, $name], $arguments);
    }

    public function all()
    {
        return $this->get('*');
    }

    public function find($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $instance = new static();
            $instance->attributes = $result;
            $instance->loadEagerRelations(); // Load eager relations
            return $instance;
        }
        return null;
    }

    public function belongsTo($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        $foreignKey = $foreignKey ?: strtolower(basename(str_replace('\\', '/', $relatedModel))) . '_id';
        $relatedModelInstance = new $relatedModel();
        return $relatedModelInstance->find($this->attributes[$foreignKey]);
    }
    public function create(array $data)
    {
        try {
            // Filter out guarded fields
            $fillableData = array_diff_key($data, array_flip($this->guarded));

            // Prepare SQL statement
            $columns = implode(',', array_keys($fillableData));
            $values = implode(',', array_fill(0, count($fillableData), '?'));
            $stmt = $this->db->getConnection()->prepare("INSERT INTO {$this->tableName} ({$columns}) VALUES ({$values})");

            // Execute statement
            $stmt->execute(array_values($fillableData));

            // Get last insert ID
            $lastInsertId = $this->db->getConnection()->lastInsertId();

            // Return newly created instance
            $newInstance = $this->find($lastInsertId);

            // Determine singular name for the table
            $singularName = $this->getSingularTableName();

            return [
                'status' => 'success',
                'message' => "{$singularName} created successfully.",
                'data' => $newInstance
            ];

        } catch (\PDOException $e) {
            // Log error
            error_log('PDOException: ' . $e->getMessage());

            // Determine specific error type
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            $message = 'An error occurred while creating the record.';

            switch ($errorCode) {
                case '23000': // Integrity constraint violation (e.g., duplicate entry)
                    if (strpos($errorMessage, 'Duplicate entry') !== false) {
                        // Extract duplicate entry information
                        if (preg_match('/Duplicate entry \'(.*?)\' for key \'(.*?)\'/', $errorMessage, $matches)) {
                            $duplicateValue = $matches[1];
                            $duplicateKey = $matches[2];
                            $message = "Duplicate entry '$duplicateValue' for key '$duplicateKey'.";
                        } else {
                            $message = 'Duplicate entry error.';
                        }
                    } else {
                        $message = 'Integrity constraint violation.';
                    }
                    break;

                case '42S22': // Unknown column
                    if (preg_match('/Unknown column \'(.*?)\' in \'field list\'/', $errorMessage, $matches)) {
                        $unknownColumn = $matches[1];
                        $message = "Unknown column '$unknownColumn' in the field list.";
                    } else {
                        $message = 'Unknown column in the field list.';
                    }
                    break;

                default:
                    $message = 'An error occurred while creating the record.';
                    break;
            }

            return [
                'status' => 'error',
                'message' => $message
            ];

        } catch (\Exception $e) {
            // Log error
            error_log('Exception: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'An unexpected error occurred.'
            ];
        }
    }

    /**
     * Get the singular name of the table.
     * This is a placeholder method. You may need to adjust it based on your implementation.
     */
    private function getSingularTableName()
    {
        // Example: convert table name 'departments' to 'Department'
        return ucfirst(strtolower($this->tableName)); // Adjust if you have specific rules for singularization
    }



    public function save()
    {
        if (isset($this->attributes['id']) && $this->attributes['id']) {
            return $this->update();
        } else {
            return $this->create($this->attributes);
        }
    }

    public function update(array $data = null)
    {
        if (!isset($this->attributes['id']) || !$this->attributes['id']) {
            throw new \Exception('Cannot update record without an ID.');
        }

        $dataToUpdate = $data ?? $this->attributes;
        $fillableData = array_diff_key($dataToUpdate, array_flip($this->guarded));

        // Check for uniqueness violation only if the value has changed
        foreach ($fillableData as $column => $value) {
            if ($this->isUniqueConstraintViolated($column, $value)) {
                throw new \Exception("The value for '{$column}' must be unique.");
            }
        }

        $set = [];
        foreach ($fillableData as $column => $value) {
            $set[] = "{$column} = ?";
        }
        $set = implode(',', $set);

        $stmt = $this->db->getConnection()->prepare("UPDATE {$this->tableName} SET {$set} WHERE id = ?");
        if (!$stmt->execute(array_merge(array_values($fillableData), [$this->attributes['id']]))) {
            error_log('Update failed: ' . implode(', ', $stmt->errorInfo()));
            return false;
        }

        // Refresh the attributes after update
        $this->attributes = array_merge($this->attributes, $fillableData);
        return true;
    }

    private function isUniqueConstraintViolated($column, $value)
    {
        // Skip uniqueness check if the value is unchanged
        if ($this->attributes[$column] === $value) {
            return false;
        }

        // Check if the new value already exists in the database
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(*) FROM {$this->tableName} WHERE {$column} = ? AND id != ?");
        $stmt->execute([$value, $this->attributes['id']]);
        return $stmt->fetchColumn() > 0;
    }

    // public function update()
    // {
    //     if (!isset($this->attributes['id']) || !$this->attributes['id']) {
    //         throw new \Exception('Cannot update record without an ID.');
    //     }

    //     $fillableData = array_diff_key($this->attributes, array_flip($this->guarded));
    //     $set = [];
    //     foreach ($fillableData as $column => $value) {
    //         $set[] = "{$column} = ?";
    //     }
    //     $set = implode(',', $set);
    //     $stmt = $this->db->getConnection()->prepare("UPDATE {$this->tableName} SET {$set} WHERE id = ?");
    //     $stmt->execute(array_merge(array_values($fillableData), [$this->attributes['id']]));
    //     return $stmt->rowCount();
    // }

    // public function delete()
    // {
    //     if (!isset($this->attributes['id']) || !$this->attributes['id']) {
    //         throw new \Exception('Cannot delete record without an ID.');
    //     }

    //     // Cascade delete related models
    //     foreach ($this->getCascadingRelations() as $relation) {
    //         $relatedModels = $this->$relation();
    //         foreach ($relatedModels as $relatedModel) {
    //             $relatedModel->delete(); // Assuming related model also has a delete method
    //         } 
    //     }

    //     $stmt = $this->db->getConnection()->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
    //     $stmt->execute([$this->attributes['id']]);
    //     return $stmt->rowCount();
    // }

    public function delete()
    {
    
        if (!isset($this->attributes['id']) || !$this->attributes['id']) {
            throw new \Exception('Cannot delete record without an ID.');
        }

        // Cascade delete related models
        foreach ($this->getCascadingRelations() as $relation) {
            $relatedModels = $this->$relation(); // Call the relation method
            foreach ($relatedModels as $relatedModel) {
                $relatedModel->delete(); // Assuming related model also has a delete method
            }
        }

        // Proceed to delete the main record
        $stmt = $this->db->getConnection()->prepare("DELETE FROM {$this->tableName} WHERE id = ?");
        $stmt->execute([$this->attributes['id']]);
        return $stmt->rowCount();
    }

    public function count()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT COUNT(id) AS total_records FROM {$this->tableName} WHERE 1=1" . $this->where . $this->whereLike);
        $stmt->execute($this->params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['total_records'] : 0;
    }

    public function get($columns = '*')
    {
        if (is_string($columns) && strpos($columns, ',') !== false) {
            $columns = explode(',', $columns);
            $columns = array_map('trim', $columns);
            $columns = implode(', ', $columns);
        }

        $query = "SELECT {$columns} FROM {$this->tableName} WHERE 1=1";
        if (!empty($this->where)) {
            $query .= $this->where;
        }
        if (!empty($this->whereLike)) {
            $query .= $this->whereLike;
        }
        if (!empty($this->orderBy)) {
            $query .= $this->orderBy;
        }
        if (!empty($this->limit)) {
            $query .= " LIMIT {$this->limit}";
        }
        if (!empty($this->offset)) {
            $query .= " OFFSET {$this->offset}";
        }

        $stmt = $this->db->getConnection()->prepare($query);
        foreach ($this->params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : (is_bool($value) ? PDO::PARAM_BOOL : (is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR));
            $stmt->bindValue($key + 1, $value, $paramType);
        }
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->resetConditions();

        $instances = [];
        foreach ($results as $result) {
            $instance = new static();
            $instance->attributes = $result;
            $instance->loadEagerRelations();
            $instances[] = $instance;
        }

        return $instances;
    }

    public function one()
    {
        $stmt = $this->db->getConnection()->query("SELECT * FROM {$this->tableName} LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function __set($name, $value)
    {
        if ($name === 'password') {
            $this->attributes[$name] = password_hash($value, PASSWORD_DEFAULT);
        } elseif ($name === 'created_at' || $name === 'updated_at') {
            $this->attributes[$name] = date('Y-m-d H:i:s', strtotime($value));
        } else {
            $this->attributes[$name] = $value;
        }
    }

    public function __get($name)
    {
        // Check if the requested property is a relation
        if (method_exists($this, $name)) {
            $relatedModel = $this->$name();
            if ($relatedModel) {
                return $relatedModel;
            }
        }

        // Return attribute if it exists
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        return null;
    }

    public function __toString()
    {
        return json_encode($this->getAttributes());
    }

    public function __debugInfo()
    {
        return $this->getAttributes();
    }

    public function hasOne($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        $foreignKey = $foreignKey ?: strtolower(basename(str_replace('\\', '/', $relatedModel))) . '_id';
        return (new $relatedModel())->where([$foreignKey => $this->$localKey])->one();
    }

    public function hasMany($relatedModel, $foreignKey = null, $localKey = 'id')
    {
        $foreignKey = $foreignKey ?: strtolower(basename(str_replace('\\', '/', $this->tableName))) . '_id';
        return (new $relatedModel())->where([$foreignKey => $this->$localKey]);
    }

    public function belongsToMany($relatedModel, $pivotTable, $foreignKey = null, $relatedKey = null)
    {
        $foreignKey = $foreignKey ?: strtolower(basename(str_replace('\\', '/', $this->tableName))) . '_id';
        $relatedKey = $relatedKey ?: strtolower(basename(str_replace('\\', '/', $relatedModel))) . '_id';

        $pivot = new $pivotTable();
        $pivotRecords = $pivot->where([$foreignKey => $this->attributes['id']]);

        $relatedModels = [];
        foreach ($pivotRecords as $pivotRecord) {
            $relatedModels[] = (new $relatedModel())->find($pivotRecord->$relatedKey);
        }

        return $relatedModels;
    }

    public function where(array $conditions)
    {
        $whereClauses = [];
        $this->params = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "{$column} = ?";
            $this->params[] = $value;
        }
        $this->where = ' AND ' . implode(' AND ', $whereClauses);
        return $this;
    }


    /**
     * Adds a WHERE IN clause to the query.
     *
     * @param string $column The column to check against.
     * @param array $values An array of values to match against.
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $placeholders = implode(',', array_map(fn() => '?', $values));
        $this->where .= " AND {$column} IN ({$placeholders})";
        $this->params = array_merge($this->params, $values);
        return $this;
    }

    /**
     * Adds a WHERE NOT IN clause to the query.
     *
     * @param string $column The column to check against.
     * @param array $values An array of values to exclude.
     * @return $this
     */
    public function whereNotIn($column, $values)
    {
        $placeholders = implode(',', array_map(fn() => '?', $values));
        $this->where .= " AND {$column} NOT IN ({$placeholders})";
        $this->params = array_merge($this->params, $values); // Merge values into params array
        return $this;
    }


    public function whereLike(array $conditions)
    {
        $whereLikeClauses = [];
        $this->params = [];
        foreach ($conditions as $column => $value) {
            $whereLikeClauses[] = "{$column} LIKE ?";
            $this->params[] = "%{$value}%";
        }
        $this->whereLike = ' AND ' . implode(' AND ', $whereLikeClauses);
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = (int) $offset;
        return $this;
    }

    public function paginate($itemsPerPage)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        // Count total records
        $countQuery = "SELECT COUNT(*) AS total_records FROM {$this->tableName} WHERE 1=1" . $this->where . $this->whereLike;
        $countStmt = $this->db->getConnection()->prepare($countQuery);
        $countStmt->execute($this->params);
        $totalItems = $countStmt->fetchColumn();

        // Calculate total pages
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Fetch paginated data
        $query = "SELECT * FROM {$this->tableName} WHERE 1=1" . $this->where . $this->whereLike . $this->orderBy . " LIMIT {$offset}, {$itemsPerPage}";
        $stmt = $this->db->getConnection()->prepare($query);
        foreach ($this->params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : (is_bool($value) ? PDO::PARAM_BOOL : (is_null($value) ? PDO::PARAM_NULL : PDO::PARAM_STR));
            $stmt->bindValue($key + 1, $value, $paramType); // Bind by position
        }
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Reset conditions after pagination query
        $this->resetConditions();

        // Pagination details
        $pagination = [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_items' => $totalItems,
            'items_per_page' => $itemsPerPage,
            'previous_page' => $page > 1 ? $page - 1 : null,
            'next_page' => $page < $totalPages ? $page + 1 : null,
            'first_page' => 1,
            'last_page' => $totalPages,
        ];

        $instances = [];
        foreach ($items as $item) {
            $instance = new static();
            $instance->attributes = $item;
            $instance->loadEagerRelations(); // Load eager relations
            $instances[] = $instance;
        }

        return [
            'draw' => isset($_GET['draw']) ? (int) $_GET['draw'] : 1,
            'recordsTotal' => $totalItems,
            'recordsFiltered' => $totalItems,
            'data' => $instances,
            'pagination' => $pagination,
        ];
    }

    public function with(array $relations)
    {
        $this->eagerLoad = $relations;
        return $this;
    }

    protected function loadEagerRelations()
    {
        foreach ($this->eagerLoad as $relation) {
            if (method_exists($this, $relation)) {
                $this->$relation = $this->$relation(); // Call the relation method
            }
        }
    }

    protected function resetConditions()
    {
        $this->where = '';
        $this->whereLike = '';
        $this->params = [];
        $this->orderBy = '';
        $this->limit = '';
        $this->offset = '';
        $this->eagerLoad = [];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    protected function getCascadingRelations()
    {
        // Return an array of related models that should be cascaded on delete
        return [];
    }
}
