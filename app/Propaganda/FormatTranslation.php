<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class FormatTranslation extends Model
{
    public $timestamps = false;
    protected $connection = 'tfc_propaganda';
    protected $fillable = ['title'];

    public function translated()
    {
        return $this->belongsTo(Format::class);
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
