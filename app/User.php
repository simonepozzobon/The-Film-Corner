<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function role() {
      return $this->belongsTo(Role::class);
    }

    public function sessions() {
        return $this->hasMany(Session::class);
    }

    public function networks() {
        return $this->hasMany(Network::class);
    }

    // https://laracasts.com/discuss/channels/laravel/user-to-user-relationship
    public function students() {
        return $this->belongsToMany(User::class, 'student_user', 'user_id', 'student_id');
    }

    public function add_student(User $user) {
        $this->students()->attach($user->id);
    }

    public function remove_student(User $user) {
        $this->students()->detach($user->id);
    }
}
