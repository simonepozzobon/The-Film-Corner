<?php

namespace App\Http\Controllers\Api;

use App\App;
use App\AppSection;
use App\AppCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function get_studios() {
        $studios = AppSection::with('categories.apps')->orderBy('order')->get();
        $studios = $studios->filter(function($studio, $key){
            return $studio->active == 1;
        });

        return [
            'success' => true,
            'studios' => $studios
        ];
    }

    public function get_studio($slug) {
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

    public function get_cat($slug) {
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

    public function get_app($slug) {
        $app = App::where('slug', $slug)->with('category.section')->first();
        if ($app) {
            return [
                'success' => true,
                'app' => $app,
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
