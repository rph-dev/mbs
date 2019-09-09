<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MbsMessageList extends Model
{
    use SoftDeletes;

    public $table = 'mbs_messages_list';

    public $fillable = [
        'message_id',
        'group_id',
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
        'message_id' => 'integer',
        'group_id' => 'integer',
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

    public function message(){
        return $this->belongsTo(
            'App\Models\Mbs\MbsMessage',
            'message_id',
            'id'
        );
    }

    public function group(){
        return $this->hasMany(
            'App\Models\Mbs\MbsGroup',
            'group_id',
            'group_id'
        );
    }

}
