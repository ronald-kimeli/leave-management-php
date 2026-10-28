<?php

namespace app\models;

use app\support\BaseModel;

class Department extends BaseModel {
    protected $tableName = 'departments';
    protected $fillable = ['name', 'description']; 
}
