<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsMessage
 * @package App\Models\Mbs
 */
class MbsMessage extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_messages';

    /**
     * @var array
     */
    public $fillable = [
        'title',
        'detail',
        'type',
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
        'title' => 'string',
        'detail' => 'string',
        'type' => 'string',
        'created_at' => 'datetime:d/m/Y H:i',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(){
        return $this->hasMany(
            'App\Models\Mbs\MbsMessageFiles',
            'message_id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userProfile(){
        return $this->belongsTo(
            'App\Models\User\User',
            'user_id',
            'id'
        );
    }


}
