<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name', 'location', 'description'];
    protected $table = 'partners';
    protected $fillable = ['logo_url', 'id_tag', 'url'];

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }

}
