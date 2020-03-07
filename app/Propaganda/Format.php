<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';

    protected $table = 'formats';
    public $translatedAttributes = ['title'];
    // public $translationModel = 'App\Propaganda\FormatTranslation';

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public static function get_db_table()
    {
        return with(new static)->getTable();
    }
}
