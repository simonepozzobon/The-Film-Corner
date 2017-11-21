<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppCategory extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name', 'description'];
    protected $table = 'app_categories';
    protected $fillable = ['slug'];

    public function section()
    {
      return $this->belongsTo('App\AppSection', 'app_section_id', 'id');
    }

    public function keywords()
    {
      return $this->hasMany('App\AppKeyword', 'app_category_id', 'id');
    }

    public function apps()
    {
      return $this->hasMany('App\App');
    }

    public function videos()
    {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios()
    {
      return $this->morphToMany('App\Audio', 'audioable');
    }

    public function medias()
    {
      return $this->morphToMany('App\Media', 'mediaable');
    }
}
