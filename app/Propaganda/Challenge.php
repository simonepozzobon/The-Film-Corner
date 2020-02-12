<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';

    protected $table = 'challenges';
    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['has_library'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
