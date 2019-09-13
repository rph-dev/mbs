<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsUserCustom
 * @package App\Models\Mbs
 */
class MbsUserCustom extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_users_custom';

    /**
     * @var array
     */
    public $fillable = [
        'name',
        'password_rand',
        'detail',
        'activated'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'password' => 'string',
        'detail' => 'string',
        'activated' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
