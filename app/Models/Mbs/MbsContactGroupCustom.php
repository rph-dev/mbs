<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MbsContactGroupCustom extends Model
{
    use SoftDeletes;

    public $table = 'mbs_contact_group_custom';

    public $fillable = [
        'name',
        'detail',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'detail' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function groupCustomUserList(){
        return $this->hasMany(
            'App\Models\Mbs\MbsContactGroupCustomUserList',
            'custom_group_id',
            'id'
        );
    }
}
