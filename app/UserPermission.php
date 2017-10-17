<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'permissions';

    public function roles()
    {
      return $this->belongsToMany('App\UserRole');
    }
}
