<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models\User
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'position_id', 'department_id', 'activated', 'line_code', 'birth_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get scope User Active
     * @return mixed
     */
    public function scopeUserActive($query) {
        return $query->where('activated', true);
    }

    /**
     * @param $query
     * @param array $value
     * @return mixed
     */
    public function scopeExclude($query, array $value)
    {
        return $query->select( array_diff( $this->fillable, $value) );
    }

    /**
     * get department.
     *
     * @return mixed
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * get position.
     *
     * @return mixed
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lineMapping()
    {
        return $this->hasOne('App\Models\Mbs\MbsUserMapping', 'user_id', 'id');
    }

    /**
     * @param null $departmentId
     * @return mixed
     */
    public function getUsersDepartment($departmentId = null){
        $users = self::with(['position', 'department', 'lineMapping']);

        if($departmentId) {
            $users->where('department_id', $departmentId);
        }

        return $users;
    }
}
