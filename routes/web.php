<?php

use App\Post;
use App\Partner;
use Illuminate\Support\Facades\Redis;
use App\Events\UserSignin;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('/test', 'Api\LoadController@test');
Route::get('/test', 'Api\Admin\ClipsController@test');
// Route::get('/test', 'Api\TranslationController@get_translations');
// Route::get('/test', 'Api\Admin\ClipsController@test');
// Route::get('/test', 'Api\PropagandaController@test');
// Route::get('/test', 'Api\SectionController@test');
// Route::get('/test', 'Api\SectionController@get_network');
// Route::get('/fill-trans', 'Api\TestController@fill_empty_translations');

// Route::get('/convert-session-to-network', 'Api\TestController@convert_shared_sessions_to_networs');
// Route::get('/convert-teachers', 'Api\TestController@convert_teacher_to_user');
// Route::get('/convert-students', 'Api\TestController@convert_student_to_user');
Route::get('/admin/{any?}', 'BackendController@home_page')->where('any', '.*')->name('admin');
Route::get('{any}', 'FrontendController@home_page')->where('any', '.*')->name('home.page');
