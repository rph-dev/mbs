<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MbsContactGroupCustomUserList extends Model
{
    use SoftDeletes;

    public $table = 'mbs_contact_group_custom_user_list';

    public $fillable = [
        'custom_group_id',
        'contact_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'custom_group_id' => 'integer',
        'contact_id' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
