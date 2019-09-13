<?php

namespace App\Models\User;

use Eloquent as Model;

/**
 * App\Models\User\Department
 */
class Department extends Model
{

    /**
     * @var string
     */
    public $table = 'departments';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
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

    /**
     * @param null $departmentId
     * @return Department[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function users($departmentId = null){
        $department = $this::with(['user' => function($q){
            $q->with('position');
        }]);

        if($departmentId) {
            $department->find($departmentId);
        }

        return $department->get();
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getDepartmentList(){
        $departments = Department::pluck('name', 'id');
        return $departments;
    }

}
