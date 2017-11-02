<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaSubCategory extends Model
{
    protected $table = 'media_sub_categories';

    public function app()
    {
      return $this->belongsTo('App\App');
    }

    public function medias()
    {
      return $this->morphToMany('App\Media', 'mediaable');
    }

    public function videos()
    {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios()
    {
      return $this->morphToMany('App\Audio', 'audioable');
    }

    public function media_on_sub_category()
    {
        $medias_on_library = $this->hasMany('App\MultiSubcategory', 'media_subcategory_id', 'id')->get();
        $medias = collect();
        foreach ($medias_on_library as $key => $media) {
          $medias->push($media->mediable()->first());
        }
        return $medias;
    }
}
