<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = ['userable_id', 'userable_type'];

    public function commentable()
    {
        return $this->morphTo();
    }
}
