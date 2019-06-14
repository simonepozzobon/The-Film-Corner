<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSection extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name', 'description'];
    protected $table = 'app_sections';
    protected $fillable = ['slug'];

    public function appCategories()
    {
      return $this->hasMany('App\AppCategory', 'id', 'app_section_id');
    }

    public function categories() {
        return $this->hasMany('App\AppCategory', 'app_section_id', 'id');
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
