<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $connection = 'tfc_propaganda';
    public $translatedAttributes = ['tech_info', 'abstract', 'historical_context', 'foods'];
    protected $fillable = [];

    public function clip()
    {
        return $this->belongsTo('App\Propaganda\Clip');
    }
}
