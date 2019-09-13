<?php

namespace App\Models\Mbs;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MbsContactGroupCustom
 * @package App\Models\Mbs
 */
class MbsContactGroupCustom extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'mbs_contact_group_custom';

    /**
     * @var array
     */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupCustomUserList(){
        return $this->hasMany(
            'App\Models\Mbs\MbsContactGroupCustomUserList',
            'custom_group_id',
            'id'
        );
    }
}
