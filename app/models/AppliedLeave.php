<?php

namespace app\models;

use app\models\User;

class AppliedLeave extends BaseModel
{
    protected $tableName = 'appliedleaves';
    protected $fillable = ['applied_by', 'leavetype_id', 'description', 'from_date', 'to_date', 'status', 'remaining_days'];

    /**
     * Define the 'applied_by' relationship method to fetch the associated User.
     *
     * @return User|null
     */
    public function applied_by()
    {
        return $this->belongsTo(User::class, 'applied_by');
    }

    /**
     * Define the 'leavetype_id' relationship method to fetch the associated LeaveType.
     *
     * @return LeaveType|null
     */
    public function leavetype()
    {
        return $this->belongsTo(LeaveType::class, 'leavetype_id');
    }

}

