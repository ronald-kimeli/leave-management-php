<?php

namespace app\models;

use app\models\BaseModel;

class Department extends BaseModel {
    protected $tableName = 'departments';
    protected $fillable = ['name', 'description']; 
}
