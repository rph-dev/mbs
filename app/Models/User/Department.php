<?php

namespace App\Models\User;

use Eloquent as Model;

/**
 * App\Models\User\Department
 */
class Department extends Model
{

    public $table = 'departments';

    protected $primaryKey = 'id';

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * get department.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->hasOne(User::class, 'department_id', 'id');
    }

    public function users($departmentId = null){
        $department = $this::with(['user' => function($q){
            $q->with('position');
        }]);

        if($departmentId) {
            $department->find($departmentId);
        }

        return $department->get();
    }


    public static function getDepartmentList(){
        $departments = Department::pluck('name', 'id');
        return $departments;
    }

}
