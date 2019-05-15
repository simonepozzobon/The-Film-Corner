<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $table = 'apps';
    protected $fillable = ['slug'];

    public function sessions() {
        return $this->hasMany(Session::class);
    }

    public function network() {
        return $this->hasMany(Network::class);
    }

    public function category() {
      return $this->belongsTo('App\AppCategory', 'app_category_id', 'id');
    }

    public function videos() {
      return $this->morphToMany('App\Video', 'videoable');
    }

    public function audios() {
      return $this->morphToMany('App\Audio', 'audioable');
    }

    public function medias() {
      return $this->morphToMany('App\Media', 'mediaable');
    }

    public function mediaCategory() {
      return $this->hasMany('App\MediaSubCategory');
    }

    public function examples() {
      $videos = $this->morphToMany('App\Video', 'videoable')->where('category_id', 3)->get();
      $images = $this->morphToMany('App\Media', 'mediaable')->where('category_id', 3)->get();
      $audios = $this->morphToMany('App\Audio', 'audioable')->where('category_id', 3)->get();

      $count = $videos->count() + $audios->count() + $images->count();

      $items = [
        'count' => $count,
        'videos' => $videos,
        'images' => $images,
        'audios' => $audios,
      ];

      return $items;
    }

    // public function translations()
    // {
    //     // Trovo le colonne che sono mappate
    //     $map = TranslableMap::where('table', '=', 'apps')->get();
    //     $map_arr = $map->pluck('column');
    //
    //     $translations = collect();
    //     foreach ($map_arr as $key => $map) {
    //       // ottengo le traduzioni
    //       $t = Translate::where([
    //         ['column', '=', $map],
    //         ['translable_type', '=', get_class($this)]
    //       ])->get();
    //
    //       // formatto l'oggetto traduzione
    //       if ($t->count() > 0) {
    //         $obj = collect();
    //         $obj->column = $map;
    //         $obj->translation = $t;
    //         $translations->push($obj);
    //       } else {
    //         $obj = collect();
    //         $obj->column = $map;
    //         $obj->translation = collect();
    //         $translations->push($obj);
    //       }
    //     }
    //
    //     return $translations;
    // }
}
