<?php

namespace app\models;

use app\support\BaseModel;

class LeaveType extends BaseModel {
    protected $tableName = 'leavetypes';
    protected $fillable = ['name', 'description', 'minimum_period']; 
}
