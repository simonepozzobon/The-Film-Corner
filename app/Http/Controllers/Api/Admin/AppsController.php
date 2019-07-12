<?php

namespace App\Http\Controllers\Api\Admin;

use App\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppsController extends Controller
{
    public function get_apps() {
        $apps = App::all();
        return [
            'success' => true,
            'apps' => $apps
        ];
    }
}
