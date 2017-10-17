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

Route::get('apps/relations/{type}/{id}', 'Admin\Apps\VideoController@getRelations');
Route::post('apps/video', 'Admin\Apps\VideoController@uploadVideo');
Route::delete('apps/video/{id}', 'Admin\Apps\VideoController@deleteVideo');

Route::post('apps/audio', 'Admin\Apps\AudioController@uploadAudio');
Route::delete('apps/audio/{id}', 'Admin\Apps\AudioController@deleteAudio');
