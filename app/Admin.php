<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';
    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {
      return $this->hasMany('App\Post');
    }

    public function getIsAdminAttribute()
    {
        return true;
    }

    public static function check()
    {
        return Auth::guard('admin')->check();
    }

    public static function user()
    {
        return Auth::guard('admin')->user();
    }
}
