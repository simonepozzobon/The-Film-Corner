<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';

    protected $table = 'directors';
    public $translatedAttributes = ['name'];

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Director', 'clip_director', 'director_id', 'clip_id');
    }

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
