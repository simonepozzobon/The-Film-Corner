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

Route::prefix('v1')->group(function() {
    // Likes
    Route::post('add-like', 'Api\LikeController@addLike');
    Route::post('destroy-like', 'Api\LikeController@destroy');

    // Comments
    Route::post('send-comment', 'Api\CommentController@sendComment');
    Route::post('destroy-comment', 'Api\CommentController@destroy');

    // Chat
    Route::post('chat-notification', 'Api\ChatController@message');
    Route::post('chat-history', 'Api\ChatController@history');
    Route::post('chat-typing', 'Api\ChatController@typing');
    Route::post('remove-notifications', 'Api\ChatController@removeNotifications');

    // Video Editor
    Route::post('/video-edit', 'VideoEditorController@updateEditor');

    // Audio Editor
    Route::post('/audio-edit', 'AudioEditorController@updateEditor');

    // Welcome form
    Route::post('/welcome/save', 'Api\GeneralController@welcome_save');

    // Feedbacks
    Route::post('/send-feedback', 'Api\GeneralController@save_feedback');

    // Admin Contest
    Route::get('/get-contest', 'Admin\ContestController@get_video');
    Route::get('/app-chart', 'Admin\StatsController@get_app_chart');
    Route::get('/page-views-stats', 'Admin\StatsController@get_page_views');

    // Cinemaf
    Route::prefix('cinemaf')->group(function() {
        Route::prefix('get')->group(function() {
            Route::get('teachers', 'Admin\CinemafController@get_teachers');
        });

        Route::prefix('post')->group(function() {
            Route::post('auth', 'Admin\CinemafController@auth');
        });
    });
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


Route::prefix('v2')->group(function() {
    Route::post('get-token', 'Api\AuthController@attempt_login_from_cookie');
    Route::post('login', 'Api\AuthController@attempt_login');
    Route::get('logout', 'Api\AuthController@attempt_logout')->middleware('auth:api');

    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('get-studios', 'Api\SectionController@get_studios');
        Route::get('get-studio/{slug}', 'Api\SectionController@get_studio');
        Route::get('get-cat/{slug}', 'Api\SectionController@get_cat');
        Route::get('get-app/{slug}', 'Api\SectionController@get_app');
        Route::get('load-assets/{slug}', 'Api\LoadController@load_assets');
    });
});
