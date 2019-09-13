<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsGroup
 * @package App\Models\Mbs
 */
class MbsGroup extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_group';

    /**
     * @var array
     */
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
