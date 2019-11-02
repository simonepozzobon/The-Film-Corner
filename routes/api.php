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

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

// Video
Route::post('apps/video', 'Admin\Apps\VideoController@uploadVideo');
Route::delete('apps/video/{id}', 'Admin\Apps\VideoController@deleteVideo');

// Audio
Route::post('apps/audio', 'Admin\Apps\AudioController@uploadAudio');
Route::delete('apps/audio/{id}', 'Admin\Apps\AudioController@deleteAudio');

// Images
Route::post('apps/image', 'Admin\Apps\MediaController@uploadMedia');
Route::delete('apps/image/{id}', 'Admin\Apps\MediaController@deleteMedia');


Route::prefix('v2')->group(
    function () {
        Route::post('get-token', 'Api\AuthController@attempt_login_from_cookie');
        Route::post('login', 'Api\AuthController@attempt_login');
        Route::get('logout', 'Api\AuthController@attempt_logout')->middleware('auth:api');
        Route::get('news', 'Api\PublicController@get_news');
        Route::get('news/{slug}', 'Api\PublicController@get_single_news');

        Route::prefix('translate')->group(
            function () {
                Route::get('', 'Api\TranslationController@get_translations');
            }
        );

        Route::group(
            ['middleware' => ['auth:api']],
            function () {
                Route::get('get-studios', 'Api\SectionController@get_studios');
                Route::get('get-studio/{slug}', 'Api\SectionController@get_studio');
                Route::get('get-cat/{slug}', 'Api\SectionController@get_cat');
                Route::get('get-app/{slug}', 'Api\SectionController@get_app');

                Route::get('load-assets/{slug}/{token?}', 'Api\LoadController@load_assets');
                Route::post('session', 'Api\LoadController@save_session');
                Route::post('session/share-to-teacher', 'Api\LoadController@share_to_teacher');
                Route::post('session/share-to-network', 'Api\LoadController@share_to_network');
                Route::delete('session/{token}/{clean}', 'Api\LoadController@delete_session')->defaults('clean', true);

                Route::post('render-video', 'Api\VideoEditorController@update_editor');
                Route::post('render-audio', 'Api\AudioEditorController@update_editor');
                Route::post('render-mixed', 'Api\MixedEditorController@update_editor');

                Route::put('contest-upload', 'Api\LoadController@contest_upload');
                Route::post('asset-upload', 'Api\LoadController@upload_asset');

                Route::get('get-network', 'Api\SectionController@get_network');
                Route::get('get-network-single/{id}', 'Api\SectionController@get_network_single');
                Route::get('like-network/{id}', 'Api\SectionController@add_network_like');

                Route::prefix('profile')->group(
                    function () {
                        Route::get('/', 'Api\ProfileController@get_profile');
                        Route::delete('/network/{id}', 'Api\ProfileController@destroy_network');
                        Route::delete('/activity/{id}', 'Api\ProfileController@destroy_activity');

                        Route::prefix('student')->group(
                            function () {
                                Route::post('save', 'Api\ProfileController@save_student');
                                Route::post('edit', 'Api\ProfileController@update_student');
                            }
                        );
                    }
                );
            }
        );

        Route::prefix('admin')->group(
            function () {
                Route::prefix('users')->group(
                    function () {
                        Route::get('/', 'Api\Admin\UserController@get_users');
                        Route::delete('{id}', 'Api\Admin\UserController@destroy');
                        Route::post('save', 'Api\Admin\UserController@save_user');
                    }
                );

                Route::prefix('apps')->group(
                    function () {
                        Route::get('/', 'Api\Admin\AppsController@get_apps');
                        Route::get('load-assets/{slug}/{token?}', 'Api\LoadController@load_assets');
                    }
                );

                Route::prefix('clips')->group(
                    function () {
                        Route::get('/', 'Api\Admin\ClipsController@get_clips');
                        Route::delete('/{id}', 'Api\Admin\ClipsController@destroy_clip');
                        Route::get('/get-initials', 'Api\Admin\ClipsController@get_initials');
                        Route::post('/create-detail', 'Api\Admin\ClipsController@store_details');
                        Route::post('/create-paratexts', 'Api\Admin\ClipsController@store_paratexts');
                        Route::post('/create', 'Api\Admin\ClipsController@store');

                        Route::prefix('paratexts')->group(
                            function () {
                                Route::post('upload', 'Api\Admin\ClipsController@upload_paratext');
                                Route::post('destroy', 'Api\Admin\ClipsController@destroy_paratext');
                                Route::post('add-content', 'Api\Admin\ClipsController@add_paratext_content');
                            }
                        );

                        Route::prefix('libraries')->group(
                            function () {
                                Route::post('test', 'Api\Admin\LibraryController@test');
                                Route::post('upload', 'Api\Admin\LibraryController@upload_media');
                                Route::delete('{id}', 'Api\Admin\LibraryController@destroy_media');
                            }
                        );
                    }
                );

                Route::prefix('translate')->group(
                    function () {
                        Route::get('/', 'Admin\TranslateController@get_languages');
                        Route::post('elements', 'Admin\TranslateController@get_elements');
                        Route::post('save', 'Admin\TranslateController@save');
                    }
                );

                Route::prefix('news')->group(
                    function () {
                        Route::get('/', 'Api\Admin\NewsController@get_all');
                        Route::post('/upload-image', 'Api\Admin\NewsController@upload_img');
                        Route::post('/save', 'Api\Admin\NewsController@save');
                        Route::delete('{id}', 'Api\Admin\NewsController@destroy');
                    }
                );
            }
        );
    }
);


// General request
// Route::get('apps/relations/media-sub-categories/{id}', 'Admin\Apps\GeneralController@getSubCategories');
// Route::get('apps/relations/{type}/{id}', 'Admin\Apps\GeneralController@getRelations');


// Route::prefix('v1')->group(function() {
//     // Likes
//     Route::post('add-like', 'Api\LikeController@addLike');
//     Route::post('destroy-like', 'Api\LikeController@destroy');
//
//     // Comments
//     Route::post('send-comment', 'Api\CommentController@sendComment');
//     Route::post('destroy-comment', 'Api\CommentController@destroy');
//
//     // Chat
//     Route::post('chat-notification', 'Api\ChatController@message');
//     Route::post('chat-history', 'Api\ChatController@history');
//     Route::post('chat-typing', 'Api\ChatController@typing');
//     Route::post('remove-notifications', 'Api\ChatController@removeNotifications');
//
//     // Video Editor
//     Route::post('/video-edit', 'VideoEditorController@updateEditor');
//
//     // Audio Editor
//     Route::post('/audio-edit', 'AudioEditorController@updateEditor');
//
//     // Welcome form
//     Route::post('/welcome/save', 'Api\GeneralController@welcome_save');
//
//     // Feedbacks
//     Route::post('/send-feedback', 'Api\GeneralController@save_feedback');
//
//     // Admin Contest
//     Route::get('/get-contest', 'Admin\ContestController@get_video');
//     Route::get('/app-chart', 'Admin\StatsController@get_app_chart');
//     Route::get('/page-views-stats', 'Admin\StatsController@get_page_views');
//
//     // Cinemaf
//     Route::prefix('cinemaf')->group(function() {
//         Route::prefix('get')->group(function() {
//             Route::get('teachers', 'Admin\CinemafController@get_teachers');
//         });
//
//         Route::prefix('post')->group(function() {
//             Route::post('auth', 'Admin\CinemafController@auth');
//         });
//     });
// });
