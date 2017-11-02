<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiSubcategory extends Model
{
    protected $table = 'subcategorizables';

    public function sub_category()
    {
      return $this->belongsTo('App\MediaSubCategory', 'media_subcategory_id', 'id');
    }

    public function mediable()
    {
      return $this->morphTo();
    }
}
