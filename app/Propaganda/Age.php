<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use \Dimsav\Translatable\Translatable;
    protected $connection = 'tfc_propaganda';

    protected $table = 'ages';
    public $translatedAttributes = ['title'];

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
