<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';
    protected $table = 'peoples';
    public $translatedAttributes = ['title'];

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip', 'clip_people', 'people_id', 'clip_id');
    }

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
