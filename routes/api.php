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

                Route::prefix('session')->group(
                    function () {
                        Route::post('', 'Api\LoadController@save_session');
                        Route::post('/share-to-teacher', 'Api\LoadController@share_to_teacher');
                        Route::post('/share-to-network', 'Api\LoadController@share_to_network');
                        Route::delete('/{token}/{clean}', 'Api\LoadController@delete_session')->defaults('clean', true);
                    }
                );


                Route::post('render-video', 'Api\VideoEditorController@update_editor');
                Route::post('render-audio', 'Api\AudioEditorController@update_editor');
                Route::post('render-mixed', 'Api\MixedEditorController@update_editor');

                Route::put('contest-upload', 'Api\LoadController@contest_upload');
                Route::post('asset-upload', 'Api\LoadController@upload_asset');

                Route::get('get-network', 'Api\SectionController@get_network');
                Route::get('get-network-single/{id}', 'Api\SectionController@get_network_single');
                Route::get('like-network/{id}', 'Api\SectionController@add_network_like');

                Route::prefix('propaganda')->group(
                    function () {
                        Route::get('search-options', 'Api\PropagandaController@get_search_options');
                        Route::post('advanced-search', 'Api\PropagandaController@perform_advanced_search');

                        Route::get('clips', 'Api\PropagandaController@get_clips');
                        Route::get('clip/{id}/exercise/{exercise_id}/{token?}', 'Api\PropagandaController@get_exercise_single');
                        Route::get('clip/{id}', 'Api\PropagandaController@get_clip_single');

                        Route::post('challenge/apps/upload-content', 'Api\PropagandaController@upload_challenge_content');
                        Route::get('challenge/{id}', 'Api\PropagandaController@get_challenge');
                    }
                );

                Route::prefix('profile')->group(
                    function () {
                        Route::get('/', 'Api\ProfileController@get_profile');
                        // Route::post('/', 'Api\ProfileController@get_profile');
                        Route::delete('/network/{id}', 'Api\ProfileController@destroy_network');
                        Route::delete('/activity/{id}', 'Api\ProfileController@destroy_activity');

                        Route::prefix('student')->group(
                            function () {
                                Route::post('save', 'Api\ProfileController@save_student');
                                Route::post('edit', 'Api\ProfileController@update_student');
                                Route::delete('{id}', 'Api\ProfileController@destroy_student');
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
                        Route::get('/get-initials/{id?}', 'Api\Admin\ClipsController@get_initials_edit');
                        Route::get('/get-initials', 'Api\Admin\ClipsController@get_initials');
                        Route::post('/create-detail', 'Api\Admin\ClipsController@store_details');
                        Route::post('/create-paratexts', 'Api\Admin\ClipsController@store_paratexts');
                        Route::post('/create', 'Api\Admin\ClipsController@store');
                        Route::post('/create-clip', 'Api\Admin\ClipsController@store_clip');
                        Route::post('/create-informations', 'Api\Admin\ClipsController@store_informations');
                        Route::post('/create-details', 'Api\Admin\ClipsController@store_details_new');

                        Route::prefix('translations')->group(
                            function () {
                                Route::post('title', 'Api\Admin\ClipsController@store_title_translation');
                                Route::post('details', 'Api\Admin\ClipsController@store_details_translation');
                                Route::post('paratext', 'Api\Admin\ClipsController@store_paratext_translation');
                            }
                        );

                        Route::prefix('exercises')->group(
                            function () {
                                Route::post('add', 'Api\Admin\ClipsController@add_exercise');
                                Route::post('remove', 'Api\Admin\ClipsController@remove_exercise');
                            }
                        );

                        Route::prefix('paratexts')->group(
                            function () {
                                Route::post('upload', 'Api\Admin\ClipsController@upload_paratext');
                                Route::post('destroy', 'Api\Admin\ClipsController@destroy_paratext');
                                Route::post('add-content', 'Api\Admin\ClipsController@add_paratext_content');
                            }
                        );

                        Route::prefix('captions')->group(
                            function () {
                                Route::post('upload', 'Api\Admin\ClipsController@upload_caption');
                                Route::post('destroy', 'Api\Admin\ClipsController@destroy_caption');
                            }
                        );

                        Route::prefix('libraries')->group(
                            function () {
                                Route::prefix('captions')->group(
                                    function () {
                                        Route::post('upload', 'Api\Admin\LibraryController@upload_caption');
                                        Route::post('destroy', 'Api\Admin\LibraryController@destroy_caption');
                                    }
                                );

                                Route::post('translations', 'Api\Admin\LibraryController@upload_translations');

                                Route::post('test', 'Api\Admin\LibraryController@test');
                                Route::post('upload', 'Api\Admin\LibraryController@upload_media');
                                Route::delete('destroy/{id}', 'Api\Admin\LibraryController@destroy_media');
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

                Route::prefix('home')->group(
                    function () {
                        Route::get('/', 'Api\Admin\HomeController@get_all');
                        Route::post('/save', 'Api\Admin\HomeController@save');
                        Route::post('/add-list', 'Api\Admin\HomeController@add_list');
                        Route::post('/update-list', 'Api\Admin\HomeController@update_list_translations');
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
