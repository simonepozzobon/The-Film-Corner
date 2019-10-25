<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clip()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
