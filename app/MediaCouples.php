<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCouples extends Model
{
    protected $table = "media_couples";

    public function left() {
        return $this->belongsTo(Media::class, 'left_id');
    }

    public function right() {
        return $this->belongsTo(Media::class, 'right_id');
    }
}
