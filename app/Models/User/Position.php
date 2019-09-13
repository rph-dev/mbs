<?php

namespace App\Models\User;

use Eloquent as Model;


/**
 * App\Models\User\Position
 */
class Position extends Model
{

    /**
     * @var string
     */
    public $table = 'positions';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

}
