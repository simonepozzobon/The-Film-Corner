<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\AppSection;
use App\AppCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoadController extends Controller
{
    public function load_assets($slug) {
        $app = App::where('slug', $slug)->with('category.section')->first();
        if ($app) {
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
                    break;
                case 'parallel-action':
                    break;
                case 'offscreen':
                    break;
                case 'attractions':
                    break;
                case 'whats-going-on':
                    break;
                case 'sound-atmospheres':
                    break;
                case 'soundscapes':
                    break;
                case 'stop-and-go':
                    break;
                case 'character-analysis':
                    break;
                case 'active-offscreen':
                    break;
                case 'active-parallel-action':
                    break;
                case 'sound-studio':
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
                'assets' => $assets
            ];
        } else {
            return [
                'success' => false,
                'error' => 404,
                'slug' => $slug,
            ];
        }
    }
}
