<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MbsGroup extends Model
{
    use SoftDeletes;

    public $table = 'mbs_group';

    public $fillable = [
        'group_id',
        'contact_id',
        'total',
        'user_id',
        'position_id',
        'department_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'group_id' => 'integer',
        'contact_id' => 'string',
        'total' => 'integer',
        'user_id' => 'integer',
        'position_id' => 'integer',
        'department_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
