<?php

namespace app\models;

use app\support\BaseModel;

class Role extends BaseModel
{
    protected $tableName = 'roles';
    protected $fillable = ['name', 'description'];

}
