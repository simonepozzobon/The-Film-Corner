<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function app() {
        return $this->belongsTo(App::class);
    }

    public function format_for_share()
    {
        $content = null;

        switch ($this->app->id) {
            case '1':
                $obj = json_decode($this->content);
                $content = [
                    'img' => $obj->rendered,
                    'notes' => $obj->notes,
                ];
                break;

            case '13':
                $obj = json_decode($this->content);
                $canvas = json_decode($obj->canvas);
                $content = [
                    'img' => $canvas->landscape,
                    'objects' => $canvas->objects,
                    'clothes' => $canvas->clothes,
                    'people' => $canvas->people,
                    'notes' => $obj->notes,
                ];
                break;

            default:
                $content = $this->content;
                break;
        }

        return $content;
    }
}
