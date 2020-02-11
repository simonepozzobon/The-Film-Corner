<?php

namespace App\Propaganda;

use Illuminate\Database\Eloquent\Model;

class LibraryMedia extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $connection = 'tfc_propaganda';

    protected $table = 'library_medias';

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['url', 'library_type_id', 'library_id'];

    public function library()
    {
        return $this->belongsTo('App\Propaganda\Library');
    }

    public function library_captions()
    {
        return $this->hasMany('App\Propaganda\LibraryCaption');
    }
}
