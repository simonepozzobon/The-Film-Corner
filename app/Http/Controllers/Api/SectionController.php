<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\App;
use App\Like;
use App\User;
use App\Network;
use App\AppSection;
use App\AppCategory;
use App\SharedSession;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function test()
    {
        // $result = $this->get_network();
        // $result = $this->get_network_single(46);
        $result = $this->add_network_like(47);
        dd($result);
    }

    public function add_network_like($id)
    {
        $user = Auth::user();
        $session = Network::find($id);
        $session->likes()->create([
            'userable_id' => $user->id,
            'userable_type' => 'App\User'
        ]);

        return [
            'success' => true,
            'likes' => $session->likes()->count(),
        ];
    }

    public function get_studios()
    {
        $studios = AppSection::with('categories.apps')->orderBy('order')->get();
        $studios = $studios->filter(function ($studio, $key) {
            return $studio->active == 1;
        });

        return [
            'success' => true,
            'studios' => $studios
        ];
    }

    public function get_studio($slug)
    {
        $studio = AppSection::where('slug', $slug)->with('categories.apps')->first();
        if ($studio && $studio->active == 1) {
            return [
                'success' => true,
                'studio' => $studio,
            ];
        } else {
            return [
                'success' => false,
                'error' => 404
            ];
        }
    }

    public function get_cat($slug)
    {
        $pavilion = AppCategory::where('slug', $slug)->with('apps', 'keywords')->first();
        if ($pavilion) {
            return [
                'success' => true,
                'pavilion' => $pavilion,
            ];
        } else {
            return [
                'success' => false,
                'error' => 404,
                'slug' => $slug,
            ];
        }
    }

    public function get_app($slug)
    {
        $user = Auth::user();
        $app = App::where('slug', $slug)->with('category.section')->first();

        $sessions = $user->sessions()->where([
            ['app_id', $app->id],
            ['is_empty', '!=', 1],
        ])->get();

        if ($app) {
            return [
                'success' => true,
                'app' => $app,
                'user' => $user,
                'sessions' => $sessions,
            ];
        } else {
            return [
                'success' => false,
                'error' => 404,
                'slug' => $slug,
            ];
        }
    }

    public function get_network()
    {
        // $items = SharedSession::orderBy('created_at', 'desc')->with('app', 'app.category', 'comments', 'likes')->get();
        $items = Network::orderBy('created_at', 'desc')->with('app', 'app.category', 'comments', 'likes')->get();

        // rimuove le sessioni delle app non più esistenti
        $filtered = $items->filter(function ($item, $key) {
            return $item->app != null;
        });

        // formatta le sessioni
        $sessions = $filtered->transform(function ($item, $key) {
            $item->content = $this->format_network_content($item);
            $item->views = Activity::where('description', '=', 'network_views')->forSubject($item)->count();
            return $item;
        })->all();

        return [
            'success' => true,
            'items' => $sessions,
        ];
    }

    public function get_network_single($id)
    {
        $user = Auth::user() ? Auth::user() : User::find(env('DUMMY_USER', 1));

        $item = Network::with('app', 'app.category', 'comments', 'likes')->find($id);

        $item->content = $this->format_network_content($item);
        $item->views = Activity::where('description', '=', 'network_views')->forSubject($item)->count();

        // increase view count
        activity()
            ->causedBy($user)
            ->performedOn($item)
            ->log('network_views');

        if ($item) {
            return [
                'success' => true,
                'id' => $id,
                'item' => $item
            ];
        }

        return [
            'success' => false,
            'error' => 'not-found'
        ];
    }

    public function format_network_content($share)
    {
        $item = array();
        $obj = $this->decode_obj($share->content);

        switch ($share->app_id) {
                // Film Specific - Framing - App 1 - Frame Composer
            case '1':
                $item['media_type'] = 'image';
                $item['featured_media'] = $obj->img;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Framing - App 2 - Frame Crop
            case '2':
                $item['media_type'] = 'image';
                if ($obj->frames && $obj->frames[0] && isset($obj->frames[0]->img)) {
                    $item['featured_media'] = $obj->frames[0]->img;
                    $item['notes'] = $obj->frames[0]->description;
                } else {
                    $item['featured_media'] = 'no-img';
                    $item['notes'] = null;
                }
                break;

                // Film Specific - Framing - App 3 - types-of-images
            case '3':
                // dd(gettype($obj));
                $item['media_type'] = 'image';
                $item['featured_media'] = $obj->images[0];
                $item['notes'] = $obj->notes;

                break;

            case '4':
                $item['media_type'] = 'video';
                $item['featured_media'] = '/' . $obj->video;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Editing - App 5 - Offscreen
            case '5':
                $item['media_type'] = 'video';
                $item['featured_media'] = $obj->video;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Editing - App 6 - Attractions
            case '6':
                $item['media_type'] = 'image';
                $item['featured_media'] = $obj->videoL;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Sound - App 7 - What's going on
            case '7':
                $item['media_type'] = 'audio';
                $item['featured_media'] = $obj->audio;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Sound - App 8 - Sound Atmosphere
            case '8':
                $item['media_type'] = 'video';
                $item['featured_media'] = $obj->video;
                $item['notes'] = $obj->notes;
                break;

                // Film Specific - Sound - App 9 - Soundscapes
            case '9':
                $item['media_type'] = 'video';
                if (isset($obj->exp) && $obj->exp) {
                    $item['featured_media'] = Storage::disk('local')->url($obj->exp);
                } else {
                    $item['featured_media'] = 'no-video';
                }
                $item['notes'] = $obj->notes;
                break;

                // Creative Studio - Warm up - App 10 - Active Offscreen
            case '10':
                $item['media_type'] = 'video';
                if ($obj->videos && $obj->videos[0] && isset($obj->videos[0]->video)) {
                    $item['featured_media'] = Storage::disk('local')->url($obj->videos[0]->video);
                } else {
                    $item['featured_media'] = 'no-video';
                }
                $item['notes'] = '';
                break;

                // Creative Studio - Warm up - App 11 - Active Parallel Action
            case '11':
                $item['media_type'] = 'video';
                $item['featured_media'] = '/' . $obj->video;
                $item['notes'] = '';
                break;

                // Creative Studio - Warm up - App 12 - Sound Studio
            case '12':
                $item['media_type'] = 'video';
                if (isset($obj->videos) && $obj->videos && $obj->videos[0] && isset($obj->videos[0]->video)) {
                    $item['featured_media'] = Storage::disk('local')->url($obj->videos[0]->video);
                } else {
                    $item['featured_media'] = 'no-video';
                }
                $item['notes'] = '';
                break;

                // Creative Studio - Story Telling - App 13 - Character Builder
            case '13':
                $item['media_type'] = 'image';
                $item['featured_media'] = $obj->img;
                $item['notes'] = $obj->notes;
                break;

                // Creative Studio - Story Telling - App 14 - Storytelling
            case '14':
                $item['media_type'] = 'text';
                $item['featured_media'] = '';
                $item['notes'] = $obj->notes;
                break;

                // Creative Studio - Story Telling - App 15 - Storyboard
            case '15':
                $item['media_type'] = 'image';
                $item['featured_media'] = $obj[0]->img;
                $item['notes'] = $obj[0]->description;
                break;

                // Creative Studio - Contest - App 16 - Minuto Lumiere
            case '16':
                $item['media_type'] = 'video';
                $item['featured_media'] = Storage::disk('local')->url($obj->video->video);
                $item['notes'] = '';
                break;

                // Creative Studio - Contest - App 16 - Make Your Own film
            case '17':
                $item['media_type'] = 'video';
                $item['thumb'] = $obj->video->img;
                $item['featured_media'] = Storage::disk('local')->url($obj->video->video);
                $item['notes'] = '';
                break;
        }

        return $item;
    }

    public function decode_obj($content)
    {
        $obj = json_decode($content);
        if (gettype($obj) == 'array') {
            $obj = json_decode($obj[0]);
        }

        return $obj;
    }
}
