<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'location', 'description'];
}
