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
// Route::get('/test', 'Api\TranslationController@get_translations');
// Route::get('/test', 'Api\Admin\ClipsController@test');
Route::get('/test', 'Api\PropagandaController@test');
// Route::get('/test', 'Api\SectionController@test');

Route::get('/convert-teachers', 'Api\TestController@convert_teacher_to_user');
Route::get('/convert-students', 'Api\TestController@convert_student_to_user');
Route::get('/admin/{any?}', 'BackendController@home_page')->where('any', '.*')->name('admin');
Route::get('{any}', 'FrontendController@home_page')->where('any', '.*')->name('home.page');

// Route::get('/test', 'Admin\StatsController@get_page_views');
// Route::get('/test', 'Debug\MediaLibraryController@media_library_fix');
// Route::get('/fix-offscreen', 'Debug\MediaLibraryController@fix_offscreen');
// Route::get('/fix-active-offscreen', 'Debug\MediaLibraryController@fix_active_offscreen');
// Route::get('/fix-parallel-action', 'Debug\MediaLibraryController@active_parallel_action_video_library');
//
// Route::get('/timeline', function(){
//     return view('timeline');
// });
//
// Route::prefix('feedback')->group(function() {
//     Route::post('feedback-api', 'FeedbackController@save')->name('save.feedback');
// });
//
// // Feedback controller
// Route::post('/feedback', 'Main\FooterController@store')->name('send.feedback');
//
// /*
// |--------------------------------------------------------------------------
// | COMPLETED
// |--------------------------------------------------------------------------
// */
//
// Route::get('/filmography', 'Main\FilmographyController@index')->name('filmography');
// Route::get('/schools', 'FrontendController@schools')->name('schools');
//
// Route::get('/set-locale/{lang}', 'FrontendController@set_locale')->name('set.locale');
//
// Route::prefix('conference')->group(function() {
//     Route::get('/gallery', 'Main\ConferenceController@gallery')->name('conference.gallery');
//     Route::get('/download', 'Main\ConferenceController@download')->name('conference.download');
//     Route::get('/contact', 'Main\ConferenceController@contact')->name('conference.contact');
//     Route::post('/application/send', 'Main\ConferenceController@sendApplication')->name('conference.application.send');
//     Route::get('/application', 'Main\ConferenceController@application')->name('conference.application');
//     Route::get('/schedule-draft', 'Main\ConferenceController@schedule')->name('conference.schedule');
//     Route::get('/about-conference', 'Main\ConferenceController@about')->name('conference.about');
//     Route::get('/accomodation', 'Main\ConferenceController@accomodation')->name('conference.accomodation');
//     Route::get('/', 'Main\ConferenceController@index')->name('conference');
// });
//
// Route::get('blog/{slug}', 'Blog\BlogController@getSingle')->where('slug', '[\w\d\-\_]+')->name('blog.post');
//
//
// // Auth
// Auth::routes();
// // Logout
// Route::get('/logout', 'Auth\LoginController@logout');
//
//
// /*
// |
// |
// |--------------------------------------------------------------------------
// | Admin Routes (Admin Panel)
// |--------------------------------------------------------------------------
// |
// */
//
// // Admin Panel Routes
// Route::prefix('admin')->group(function () {
//
//     // Auth
//     Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
//     Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
//     Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
//     Route::get('/', 'AdminController@index')->name('admin');
//
//     // Nuovo pannello video
//     Route::get('/video', 'Admin\VideoController@adminVideo')->name('admin.video');
//     Route::get('/get-videos', 'Admin\VideoController@get_videos')->name('admin.get_videos');
//     Route::post('/save-video', 'Admin\VideoController@save_video')->name('admin.save_video');
//     Route::get('/audio', 'Admin\AudioController@adminAudio')->name('admin.audio');
//     Route::get('/get-audios', 'Admin\AudioController@get_audios')->name('admin.get_audios');
//     Route::post('/save-audio', 'Admin\AudioController@save_audio')->name('admin.save_audio');
//     Route::get('/images', 'Admin\ImageController@adminImage')->name('admin.image');
//     Route::get('/get-images', 'Admin\ImageController@get_images')->name('admin.get_images');
//     Route::post('/save-image', 'Admin\ImageController@save_image')->name('admin.save_image');
//     Route::get('/get-media-paths/{type}/{id}', 'Admin\GeneralController@get_paths')->name('admin.get_paths');
//
//     // Web menu routes
//     Route::resource('posts', 'Admin\PostController');
//     Route::resource('media', 'Admin\MediaController', ['except' => ['show', 'create']]);
//     Route::resource('categories', 'Admin\CategoryController', ['except' => ['show', 'create'] ]);
//     Route::resource('tags', 'Admin\TagController', ['except' => ['show', 'create'] ]);
//
//     // Maps settings
//     Route::prefix('map')->group( function() {
//         Route::prefix('api')->group(function() {
//             Route::get('/{id}/edit', 'Admin\PointController@edit')->name('api.map.edit');
//             Route::put('/{id}', 'Admin\PointController@update')->name('api.map.update');
//             Route::post('/', 'Admin\PointController@store')->name('api.map.store');
//             Route::delete('/{id}', 'Admin\PointController@destroy')->name('api.map.delete');
//             Route::get('/', 'Admin\PointController@index')->name('api.map.index');
//         });
//
//         // ...admin/map/ to show index
//         Route::get('/', function() {
//             return view('admin.map.index');
//         });
//     });
//
//     // Users menu routes
//     Route::get('/admins', 'Admin\AdminController@index')->name('admin.admins.index');
//     // Route::resource('teachers', 'Admin\TeacherController', ['except' => ['create']]);
//     // Route::post('teachers/{teacher}', 'Admin\TeacherController@storeStudent')->name('teacher.store.student');
//     Route::resource('students', 'Admin\StudentController', ['except' => ['create']]);
//     Route::resource('users', 'Admin\UserController', ['except' => ['create']]);
//     Route::resource('schools', 'Admin\SchoolController', ['except' => ['create']]);
//
//     // Settings menu routes
//     Route::resource('partners', 'Admin\PartnerController', ['except' => ['create'] ]);
//
//     // Stats
//     Route::get('/stats', 'Admin\StatsController@index')->name('stats.index');
//
//     // Tools
//     Route::get('/conference-applications', 'Admin\ToolController@indexExcel')->name('excel.index');
//
//     // Conference gallery
//     Route::prefix('conference')->group(function() {
//         Route::get('/gallery', 'Admin\ConferenceController@index')->name('admin.conference.gallery.index');
//         Route::post('/gallery', 'Admin\ConferenceController@store')->name('admin.conference.gallery.store');
//     });
//
//     // Translate
//     Route::prefix('translate')->group(function() {
//         Route::get('/languages', 'Admin\TranslateController@get_languages')->name('admin.translate.get_languages');
//         Route::post('/save', 'Admin\TranslateController@save')->name('admin.translate.save');
//         Route::get('/index', 'Admin\TranslateController@index')->name('admin.translate.index');
//         Route::post('/get-elements', 'Admin\TranslateController@get_elements')->name('admin.translate.get_elements');
//         Route::post('/get-translation', 'Admin\TranslateController@get_translation')->name('admin.translate.get_translation');
//     });
//
//     Route::prefix('apps')->group(function(){
//         Route::get('/glossary', 'Admin\GlossaryController@index')->name('admin.apps.glossary.index');
//         Route::post('/glossary', 'Admin\GlossaryController@store')->name('admin.apps.glossary.store');
//         Route::prefix('/captions')->group(function() {
//             Route::get('/', 'Admin\CaptionController@index')->name('admin.apps.captions.index');
//             Route::get('/get_captions', 'Admin\CaptionController@get_captions')->name('admin.apps.captions.get_captions');
//             Route::post('/store_caption', 'Admin\CaptionController@store_caption')->name('admin.apps.captions.store_caption');
//         });
//     });
//
//     Route::prefix('footer')->group(function(){
//         Route::get('/get_credits', 'Admin\FooterController@get_credits')->name('admin.credit.get_credits');
//         Route::get('/get_filmography', 'Admin\FooterController@get_filmography')->name('admin.filmography.get_filmography');
//         Route::post('/save_credit', 'Admin\FooterController@save_credit')->name('admin.credit.save');
//         Route::post('/save_filmography', 'Admin\FooterController@save_filmography')->name('admin.filmography.save');
//         Route::post('/update_credit', 'Admin\FooterController@update_credit')->name('admin.credit.update');
//         Route::post('/update_filmography', 'Admin\FooterController@update_filmography')->name('admin.filmography.update');
//         Route::get('/', 'Admin\FooterController@index')->name('admin.footer');
//     });
//
//     Route::prefix('teacher')->group(function() {
//         Route::get('/get-teachers', 'Admin\TeacherController@get_teachers')->name('admin.teacher.get_teachers');
//         Route::post('/save', 'Admin\TeacherController@save')->name('admin.teacher.save');
//         Route::post('/new', 'Admin\TeacherController@new')->name('admin.teacher.new');
//         Route::post('/delete', 'Admin\TeacherController@destroy')->name('admin.teacher.destroy');
//         Route::get('/', 'Admin\TeacherController@index')->name('admin.teacher.index');
//     });
//
//     Route::prefix('guest')->group(function() {
//         Route::get('/get-guests', 'Admin\GuestController@get_guests')->name('admin.guest.get_guests');
//         Route::post('/save', 'Admin\GuestController@save')->name('admin.guest.save');
//         Route::post('/new', 'Admin\GuestController@new')->name('admin.guest.new');
//         Route::post('/delete', 'Admin\GuestController@destroy')->name('admin.guest.destroy');
//         Route::get('/', 'Admin\GuestController@index')->name('admin.guest.index');
//     });
//
//
//     Route::prefix('tools')->group(function(){
//         // Route::get('/flush-media', 'ToolController@flush_media');
//         // Route::get('/soundstudio', 'ToolController@soundstudio_library');
//         // Route::get('/translate_filmography', 'ToolController@translate_filmography');
//         // Route::get('/translate_partner', 'ToolController@translate_partner');
//         Route::get('/flush-sound-atmosphere-library', 'ToolController@remove_video_from_sound_atmosphere');
//         Route::get('/soundstudio-video', 'ToolController@soundstudio_video_library');
//         Route::get('/put-audio-on-whats-going-on', 'ToolController@put_audio_on_whats_going_on');
//         Route::get('/convert-to-mp3/{id}', 'ToolController@convert_library');
//     });
//
//     Route::prefix('contest')->group(function() {
//         Route::get('/', 'Admin\ContestController@index')->name('admin.contest.index');
//     });
// });
//
//
// /*
// |
// |
// |--------------------------------------------------------------------------
// | Teacher Routes (Teacher Panel)
// |--------------------------------------------------------------------------
// |
// */
//
// // Teacher Panel Teacher
// Route::prefix('teacher')->group(function() {
//     // Auth
//     Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
//     Route::post('/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
//     Route::get('/logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');
//     Route::get('/', 'TeacherController@index')->name('teacher');
//     Route::get('/welcome','TeacherController@welcome')->name('teacher.welcome');
//
//     // Video Editor
//     Route::post('/video-edit/video-edit-api', 'VideoEditorController@updateEditor')->name('update.teacher.editor');
//     Route::post('/audio-edit/audio-edit-api', 'AudioEditorController@updateEditor')->name('update.teacher.audio.editor');
//
//     // Pagine Principali dei padiglioni
//
//     // Film Specific
//     Route::get('/film-specific', 'TeacherController@filmSpecific')->name('teacher.film-specific');
//     Route::get('/film-specific/{category}', 'Teacher\FilmSpecificController@index')->name('teacher.film-specific.index');
//     Route::get('/film-specific/{category}/{app_slug}/{token}', 'Teacher\FilmSpecificController@openSession')->name('teacher.film-specific.open.session');
//     Route::get('/film-specific/{category}/{app_slug}', 'Teacher\FilmSpecificController@app')->name('teacher.film-specific.app');
//
//     // Creative studio
//     Route::post('/creative-studio/upload-img/{category}/{app_slug}', 'Teacher\CreativeStudioController@uploadImg')->name('teacher.creative-studio.upload.img');
//     Route::post('/creative-studio/{category}/{app_slug}/upload', 'Teacher\CreativeStudioController@uploadVideo')->name('teacher.creative-studio.upload');
//     Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Teacher\CreativeStudioController@openSession')->name('teacher.creative-studio.open.session');
//     Route::get('/creative-studio/{category}/{app_slug}', 'Teacher\CreativeStudioController@app')->name('teacher.creative-studio.app');
//     Route::get('/creative-studio/{category}', 'Teacher\CreativeStudioController@index')->name('teacher.creative-studio.index');
//     Route::get('/creative-studio', 'TeacherController@creativeStudio')->name('teacher.creative-studio');
//
//     Route::get('/cinema', 'TeacherController@cinemaPav')->name('teacher.cinema-pav');
//     Route::get('/path_1', 'TeacherController@path')->name('teacher.path');
//
//     // Settings
//     Route::prefix('settings')->group(function() {
//       Route::get('/', 'Teacher\SettingsController@index')->name('teacher.settings.index');
//       Route::post('/store-student', 'Teacher\SettingsController@storeStudent')->name('teacher.student.store');
//       Route::post('/save-student', 'Teacher\SettingsController@save_student')->name('teacher.settings.save_student');
//       Route::post('/destroy-student', 'Teacher\SettingsController@destroy_student')->name('teacher.settings.destroy_student');
//       Route::post('/delete-student', 'Teacher\SettingsController@deleteStudent')->name('teacher.student.delete');
//       Route::post('/update-student', 'Teacher\SettingsController@update_student')->name('teacher.settings.update_student');
//       Route::get('/get-slots', 'Teacher\SettingsController@get_slots')->name('teacher.settings.get_slots');
//     });
//
//     // Network
//     Route::get('/network', 'Teacher\NetworkController@index')->name('teacher.network.index');
//     Route::get('/network/{token}', 'Teacher\NetworkController@single')->name('teacher.network.single');
//
//     // Sessioni
//     Route::prefix('session')->group(function() {
//       Route::get('/{teacher_id}/{app_id}', 'Teacher\SessionController@openSessions')->name('open.sessions');
//       Route::post('/new', 'Teacher\SessionController@newSession')->name('new.session');
//       Route::post('/update', 'Teacher\SessionController@updateSession')->name('update.session');
//       Route::post('/share-approved', 'Teacher\SessionController@shareApproved')->name('teacher.session.share_approved');
//       Route::post('/shared-destroy', 'Teacher\SessionController@destroyShared')->name('teacher.session.shared_destroy');
//       Route::post('/share', 'Teacher\SessionController@shareSession')->name('teacher.session.share');
//       Route::post('/delete', 'Teacher\SessionController@destroy')->name('teacher.session.delete');
//       Route::post('/approve', 'Teacher\SessionController@approveSession')->name('teacher.session.approve');
//     });
//
//
//     // Notifications
//     Route::prefix('notifications')->group(function() {
//       Route::get('/markasread/{id}', 'Teacher\NotificationController@markAsRead')->name('teacher.notifications.markasread');
//       Route::post('/markasunread', 'Teacher\NotificationController@markAsUnread')->name('teacher.notifications.markasunread');
//       Route::get('/get', 'Teacher\NotificationController@getNotifications')->name('teacher.notifications.getnew');
//       Route::post('/delete', 'Teacher\NotificationController@delete')->name('teacher.notifications.delete');
//       Route::post('/destroy', 'Teacher\NotificationController@destroy')->name('teacher.notifications.destroy');
//     });
//
//     Route::prefix('streaming')->group(function() {
//       Route::get('/', 'Teacher\StreamingController@index')->name('streaming.index');
//     });
// });
//
//
// /*
// |
// |
// |--------------------------------------------------------------------------
// | Student Routes (Student Panel)
// |--------------------------------------------------------------------------
// |
// */
//
// // Student Panel Routes
// Route::prefix('student')->group(function() {
//
//     // Auth
//     Route::get('/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
//     Route::post('/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
//     Route::get('/logout', 'Auth\StudentLoginController@logout');
//     Route::get('/', 'StudentController@index')->name('student');
//     Route::get('/welcome','StudentController@welcome')->name('student.welcome');
//
//     // Video Editor
//     Route::post('/video-edit/video-edit-api', 'VideoEditorController@updateEditor')->name('update.student.editor');
//     Route::post('/audio-edit/audio-edit-api', 'AudioEditorController@updateEditor')->name('update.student.audio.editor');
//
//     // Pagine Principali dei padiglioni
//
//     // Film Specific
//     Route::get('/film-specific', 'StudentController@filmSpecific')->name('student.film-specific');
//     Route::get('/film-specific/{category}', 'Student\FilmSpecificController@index')->name('student.film-specific.index');
//     Route::get('/film-specific/{category}/{app_slug}/{token}', 'Student\FilmSpecificController@openSession')->name('student.film-specific.open.session');
//     Route::get('/film-specific/{category}/{app_slug}', 'Student\FilmSpecificController@app')->name('student.film-specific.app');
//
//     // Film Specific
//     Route::get('/creative-studio', 'StudentController@creativeStudio')->name('student.creative-studio');
//     Route::post('/creative-studio/{category}/{app_slug}/upload', 'Student\CreativeStudioController@uploadVideo')->name('student.creative-studio.upload');
//     Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Student\CreativeStudioController@uploadImg')->name('student.creative-studio.upload.img');
//     Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Student\CreativeStudioController@openSession')->name('student.creative-studio.open.session');
//     Route::get('/creative-studio/{category}/{app_slug}', 'Student\CreativeStudioController@app')->name('student.creative-studio.app');
//     Route::get('/creative-studio/{category}', 'Student\CreativeStudioController@index')->name('student.creative-studio.index');
//
//     Route::get('/cinema', 'StudentController@cinemaPav')->name('student.cinema-pav');
//     Route::get('/path_1', 'StudentController@path')->name('student.path');
//
//     // Settings
//     Route::get('/settings', 'Student\SettingsController@index')->name('student.settings.index');
//     Route::post('/settings/store-student', 'Student\SettingsController@storeStudent')->name('student.student.store');
//     Route::post('/settings/delete-student', 'Student\SettingsController@deleteStudent')->name('student.student.delete');
//
//     // Network
//     Route::get('/network', 'Student\NetworkController@index')->name('student.network.index');
//     Route::get('/network/{token}', 'Student\NetworkController@single')->name('student.network.single');
//
//     // Sessioni
//     Route::get('/session/{student_id}/{app_id}', 'Student\SessionController@openSessions')->name('open.sessions');
//     Route::post('/session/new', 'Student\SessionController@newSession')->name('new.session');
//     Route::post('/session/update', 'Student\SessionController@updateSession')->name('update.session');
//     Route::post('/delete', 'Teacher\SessionController@destroy')->name('student.session.delete');
//     Route::post('/session/share', 'Student\SessionController@shareSession')->name('student.session.share');
// });
//
// // Route::get('/translate', 'Admin\TranslateController@translate')->name('test.admin');
//
//
// /*
// |
// |
// |--------------------------------------------------------------------------
// | Guest Routes (Guest Panel)
// |--------------------------------------------------------------------------
// |
// */
//
// // Guest Panel Guest
// Route::prefix('guest')->group(function() {
//     // Auth
//     Route::get('/login', 'Auth\GuestLoginController@showLoginForm')->name('guest.login');
//     Route::post('/login', 'Auth\GuestLoginController@login')->name('guest.login.submit');
//     Route::get('/logout', 'Auth\GuestLoginController@logout')->name('guest.logout');
//     Route::get('/', 'GuestController@index')->name('guest');
//     Route::get('/welcome','GuestController@welcome')->name('guest.welcome');
//
//     // Video Editor
//     Route::post('/video-edit/video-edit-api', 'VideoEditorController@updateEditor')->name('update.guest.editor');
//     Route::post('/audio-edit/audio-edit-api', 'AudioEditorController@updateEditor')->name('update.guest.audio.editor');
//
//     // Pagine Principali dei padiglioni
//
//     // Film Specific
//     Route::get('/film-specific', 'GuestController@filmSpecific')->name('guest.film-specific');
//     Route::get('/film-specific/{category}', 'Guest\FilmSpecificController@index')->name('guest.film-specific.index');
//     Route::get('/film-specific/{category}/{app_slug}/{token}', 'Guest\FilmSpecificController@openSession')->name('guest.film-specific.open.session');
//     Route::get('/film-specific/{category}/{app_slug}', 'Guest\FilmSpecificController@app')->name('guest.film-specific.app');
//
//     // Film Specific
//     Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Guest\CreativeStudioController@uploadImg')->name('guest.creative-studio.upload.img');
//     Route::post('/creative-studio/{category}/{app_slug}/upload', 'Guest\CreativeStudioController@uploadVideo')->name('guest.creative-studio.upload');
//     Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Guest\CreativeStudioController@openSession')->name('guest.creative-studio.open.session');
//     Route::get('/creative-studio/{category}/{app_slug}', 'Guest\CreativeStudioController@app')->name('guest.creative-studio.app');
//     Route::get('/creative-studio/{category}', 'Guest\CreativeStudioController@index')->name('guest.creative-studio.index');
//     Route::get('/creative-studio', 'GuestController@creativeStudio')->name('guest.creative-studio');
//
//     Route::get('/cinema', 'GuestController@cinemaPav')->name('guest.cinema-pav');
//     Route::get('/path_1', 'GuestController@path')->name('guest.path');
//
//     // Settings
//     Route::prefix('settings')->group(function() {
//       Route::get('/', 'Guest\SettingsController@index')->name('guest.settings.index');
//       Route::post('/store-student', 'Guest\SettingsController@storeStudent')->name('guest.student.store');
//       Route::post('/save-student', 'Guest\SettingsController@save_student')->name('guest.settings.save_student');
//       Route::post('/destroy-student', 'Guest\SettingsController@destroy_student')->name('guest.settings.destroy_student');
//       Route::post('/delete-student', 'Guest\SettingsController@deleteStudent')->name('guest.student.delete');
//       Route::post('/update-student', 'Guest\SettingsController@update_student')->name('guest.settings.update_student');
//       Route::get('/get-slots', 'Guest\SettingsController@get_slots')->name('guest.settings.get_slots');
//     });
//
//     // Network
//     Route::get('/network', 'Guest\NetworkController@index')->name('guest.network.index');
//     Route::get('/network/{token}', 'Guest\NetworkController@single')->name('guest.network.single');
//
//     // Sessioni
//     Route::prefix('session')->group(function() {
//       Route::get('/{guest_id}/{app_id}', 'Guest\SessionController@openSessions')->name('open.sessions');
//       Route::post('/new', 'Guest\SessionController@newSession')->name('new.session');
//       Route::post('/update', 'Guest\SessionController@updateSession')->name('update.session');
//       Route::post('/share-approved', 'Guest\SessionController@shareApproved')->name('guest.session.share_approved');
//       Route::post('/share', 'Guest\SessionController@shareSession')->name('guest.session.share');
//       Route::post('/delete', 'Guest\SessionController@destroy')->name('guest.session.delete');
//       Route::post('/approve', 'Guest\SessionController@approveSession')->name('guest.session.approve');
//     });
//
//
//     // Notifications
//     Route::prefix('notifications')->group(function() {
//       Route::get('/markasread/{id}', 'Guest\NotificationController@markAsRead')->name('guest.notifications.markasread');
//       Route::post('/markasunread', 'Guest\NotificationController@markAsUnread')->name('guest.notifications.markasunread');
//       Route::get('/get', 'Guest\NotificationController@getNotifications')->name('guest.notifications.getnew');
//       Route::post('/delete', 'Guest\NotificationController@delete')->name('guest.notifications.delete');
//       Route::post('/destroy', 'Guest\NotificationController@destroy')->name('guest.notifications.destroy');
//     });
// });
