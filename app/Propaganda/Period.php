<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $connection = 'tfc_propaganda';

    public function clips()
    {
        return $this->hasMany('App\Propaganda\Clip');
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
