<?php

namespace app\models;

use app\models\BaseModel;

class Role extends BaseModel
{
    protected $tableName = 'roles';
    protected $fillable = ['name', 'description'];

}
