<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// General request
Route::get('apps/relations/media-sub-categories/{id}', 'Admin\Apps\GeneralController@getSubCategories');
Route::get('apps/relations/{type}/{id}', 'Admin\Apps\GeneralController@getRelations');

// Video
Route::post('apps/video', 'Admin\Apps\VideoController@uploadVideo');
Route::delete('apps/video/{id}', 'Admin\Apps\VideoController@deleteVideo');

// Audio
Route::post('apps/audio', 'Admin\Apps\AudioController@uploadAudio');
Route::delete('apps/audio/{id}', 'Admin\Apps\AudioController@deleteAudio');

// Images
Route::post('apps/image', 'Admin\Apps\MediaController@uploadMedia');
Route::delete('apps/image/{id}', 'Admin\Apps\MediaController@deleteMedia');
