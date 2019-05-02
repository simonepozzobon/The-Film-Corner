<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\App;
use App\Session;
use App\AppSection;
use App\AppCategory;
use App\MediaCouples;
use App\MediaSubCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LoadController extends Controller
{
    public function load_assets($slug, $token = false) {
        $app = App::where('slug', $slug)->with('category.section')->first();

        if ($app) {
            // se non c'è nessun token, creo una nuova sessione
            if (!$token || $token == false) {
                $session = new Session();
                $session->user_id = Auth::user()->id;
                $session->app_id = $app->id;
                $session->title = 'empty';
                $session->token = uniqid();
                $session->content = json_encode([]);
                $session->save();
                $session->refresh();
            } else {
                return [
                    'success' => false,
                    'error' => 'session error',
                    'slug' => $slug,
                ];
            }

            $assets = [];
            switch ($app->slug) {

                case 'frame-composer':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => true,
                        'library' => $images,
                    ];
                    break;

                case 'frame-crop':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => false,
                        'library' => $images,
                    ];
                    break;

                case 'types-of-images':
                    $media_couples = MediaCouples::with('left', 'right')->get();
                    $media_couples = $media_couples->transform(function($item, $key) {
                        $item->leftSrc = Storage::disk('local')->url($item->left->landscape);
                        $item->rightSrc = Storage::disk('local')->url($item->right->landscape);
                        return $item;
                    });
                    $random = $media_couples->random();

                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => false,
                        'library' => $media_couples,
                        'random' => $random,
                    ];
                    break;

                case 'parallel-action':
                    $videos = MediaSubCategory::where('app_id', 4)->with('videos')->get();
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => true,
                        'library' => $videos,
                    ];
                    break;

                case 'offscreen':
                    $videos = $app->videos()->get();
                    $videos = $videos->transform(function($video, $key) {
                        $video->videoSrc = Storage::disk('local')->url($video->src);
                        return $video;
                    });
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => false,
                        'library' => $videos,
                    ];
                    break;

                case 'whats-going-on':
                    $audios = $app->audios()->get();
                    $audios = $audios->transform(function($audio, $key) {
                        $audio->audioSrc = Storage::disk('local')->url($audio->src);
                        return $audio;
                    });
                    $assets = [
                        'type' => 'audios',
                        'hasSubLibraries' => false,
                        'library' => $audios,
                    ];
                    break;

                case 'soundscapes':
                    break;

                case 'active-offscreen':
                    $videos = $app->videos()->get();
                    $videos = $videos->transform(function($video, $key) {
                        $video->videoSrc = Storage::disk('local')->url($video->src);
                        return $video;
                    });
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => false,
                        'library' => $videos,
                    ];
                    break;

                case 'active-parallel-action':
                    $videos = MediaSubCategory::where('app_id', 10)->with('videos')->get();
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => true,
                        'library' => $videos,
                    ];
                    break;
                case 'sound-studio':
                    $audios = MediaSubCategory::where('app_id', 12)->with('audios')->get();
                    $video = $app->videos()->inRandomOrder()->first();
                    $src = $video->src;
                    $assets = [
                        'type' => 'audios',
                        'hasSubLibraries' => true,
                        'library' => $audios,
                        'video' => $src
                    ];
                    break;
                case 'character-builder':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => true,
                        'library' => $images,
                    ];
                    break;

                case 'storytelling':
                    break;
                case 'storyboard':
                    break;
                case 'lumiere-minute':
                    break;
                case 'make-your-own-film':
                    break;
            }
            return [
                'success' => true,
                'app' => $app,
                'assets' => $assets,
                'session' => $session,
            ];
        } else {
            return [
                'success' => false,
                'error' => 404,
                'slug' => $slug,
            ];
        }
    }

    public function delete_session($token) {
        $session = Session::where('token', $token)->first();
        if ($session) {
            $session->delete();
            return [
                'success' => true,
            ];
        }

        return [
            'success' => false,
            'error' => 404,
        ];
    }
}
