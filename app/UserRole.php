<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'roles';

    public function users()
    {
      return $this->hasMany('App\User');
    }

    public function permissions()
    {
      return $this->belongsToMany('App\UserPermission');
    }
}
