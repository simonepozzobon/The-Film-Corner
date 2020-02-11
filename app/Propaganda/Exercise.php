<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $connection = 'tfc_propaganda';
    protected $table = 'exercises';

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['has_library', 'library_type_id', 'slug'];

    public function libraries()
    {
        return $this->hasMany('App\Propaganda\Library');
    }
}
