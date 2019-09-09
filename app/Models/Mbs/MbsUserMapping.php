<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MbsUserMapping extends Model
{
    use SoftDeletes;

    public $table = 'mbs_users_mapping';

    protected $primaryKey = 'id';

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
