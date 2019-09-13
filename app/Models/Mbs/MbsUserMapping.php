<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsUserMapping
 * @package App\Models\Mbs
 */
class MbsUserMapping extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_users_mapping';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    public $fillable = [
        'user_id',
        'line_id',
        'user_custom',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'line_id' => 'string',
        'user_custom' => 'string',
        'state' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
