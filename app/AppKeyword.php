<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKeyword extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name', 'description'];
    protected $table = 'app_keywords';

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }

    public function category()
    {
        return $this->belongsTo('App\AppCategory', 'app_category_id', 'id');
    }
}
