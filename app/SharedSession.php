<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AppsSessions\StudentAppSession;
use App\AppsSessions\AppsSession;

class SharedSession extends Model
{
    public function app()
    {
        return $this->belongsTo('App\App');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function author()
    {
        return $this->morphTo('userable');
    }

    public static function share($session, $app_id)
    {
        $shared = new SharedSession;
        $shared->app_id = $app_id;

        $class = get_class($session);
        if ($class == 'App\AppsSessions\StudentAppSession') {
            $shared->userable_type = 'App\Student';
            $shared->userable_id = $session->student_id;
        } else {
            $shared->userable_type = 'App\Teacher';
            $shared->userable_id = $session->teacher_id;
        }

        $shared->token = $session->token;
        $shared->title = $session->title;

        switch ($app_id) {
            // Film Specific - Framing - Frame Composer
            case '1':
                // estraggo l'immagine dalla sessione
                $obj = json_decode($session->content);
                $img = $obj->rendered;
                $notes = $obj->notes;

                $content = [
                    'img' => $img,
                    'notes' => $notes,
                ];

                // condivido la sessione
                $shared->content = json_encode($content);
            break;

            // Film Specific - Framing - Frame Crop
            case '2':
                // estraggo i frame dalla sessione e li salvo in quella condivisa
                $shared->content = $session->content;
            break;

            // Film Specific - Framing - types-of-images
            case '3':
                $shared->content = $session->content;
            break;

            // Film Specific - Editing - Parallel Action
            case '4':
                $shared->content = $session->content;
            break;

            // Film Specific - Editing - Offscreen
            case '5':
                $shared->content = $session->content;
            break;

            // Film Specific - Editing - Attractions
            case '6':
                $shared->content = $session->content;
            break;

            // Film Specific - Sound - What's Going On
            case '7':
                $shared->content = $session->content;
            break;

            // Film Specific - Sound - Sound Atmosphere
            case '8':
                $shared->content = $session->content;
            break;

            // Film Specific - Sound - Soundscapes
            case '9':
                $shared->content = $session->content;
            break;

            // Creative Studio - Warm Up - Active Offscreen
            case '10':
                $shared->content = $session->content;
            break;

            // Creative Studio - Warm Up - Active Parallel Action
            case '11':
                $shared->content = $session->content;
            break;

            // Creative Studio - Warm Up - Active Sound Studio
            case '12':
            $shared->content = $session->content;
            break;

            // Creative Studio - Story Telling - Character Builder
            case '13':
                // estraggo l'immagine dalla sessione
                $obj = json_decode($session->content);
                $img = $obj->rendered;
                $notes = $obj->notes;

                $content = [
                    'img' => $img,
                    'notes' => $notes,
                ];

                // condivido la sessione
                $shared->content = json_encode($content);
            break;

            // Creative Studio - Story Telling - Storytelling
            case '14':
                $shared->content = $session->content;
            break;

            // Creative Studio - Story Telling - Storyboard
            case '15':
                $shared->content = $session->content;
            break;

            // Creative Studio - Contest - Lumiere Minute
            case '16':
                $shared->content = $session->content;
            break;

            // Creative Studio - Contest - Make Your Own Film
            case '17':
                $shared->content = $session->content;
            break;
        }
        $shared->save();

        $shared->app = $shared->app->get();
        $shared->author = $shared->author()->get();
        $shared->comments = $shared->comments()->get();
        $shared->likes = $shared->likes()->get();
        $shared->comments_count = 0;
        
        return $shared;
    }
}
