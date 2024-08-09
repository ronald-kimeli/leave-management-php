<?php

namespace app\models;

class User extends BaseModel
{
    protected $tableName = 'users';
    protected $fillable = ['name', 'email', 'password', 'role_id'];

    /**
     * Define the 'role' relationship method to fetch the associated role.
     *
     * @return Role|null
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Define the 'department' relationship method to fetch the associated department.
     *
     * @return Department|null
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }


        /**
     * Paginate applied leaves and eager load related models (User and Department).
     *
     * @param int $itemsPerPage Number of items per page
     * @return array Pagination result with data and meta information
     */
    public function paginateWithRelated($itemsPerPage)
    {
        // Paginate User using the BaseModel's paginate method
        $paginationData = $this->paginate($itemsPerPage);

        // Map related models into User
        foreach ($paginationData['data'] as &$relatedModel) {
            $relatedModel['role'] = Role::model()->whereIn('id', [$relatedModel['role_id']])->get('id,name')[0]->attributes;
            $relatedModel['department'] = Department::model()->whereIn('id', [$relatedModel['department_id']])->get('id,name')[0]->attributes;
        }

        return $paginationData;
    }
}
