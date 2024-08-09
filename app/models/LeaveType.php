<?php

namespace app\models;

use app\models\BaseModel;

class LeaveType extends BaseModel {
    protected $tableName = 'leavetypes';
    protected $fillable = ['name', 'description', 'minimum_period']; 
}
