<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsMessageFiles
 * @package App\Models\Mbs
 */
class MbsMessageFiles extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_messages_files';

    /**
     * @var array
     */
    public $fillable = [
        'uid',
        'message_id',
        'file_type',
        'file_name',
        'file_name_old',
        'file_path',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid' => 'string',
        'message_id' => 'integer',
        'file_type' => 'string',
        'file_name' => 'string',
        'file_name_old' => 'string',
        'file_path' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

}
