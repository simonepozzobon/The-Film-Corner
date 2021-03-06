<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';
    protected $table = 'topics';
    public $translatedAttributes = ['title'];

    public function clip()
    {
        return $this->belongsToMany('App\Propaganda\Clip', 'clip_topic', 'topic_id', 'clip_id');
    }

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
