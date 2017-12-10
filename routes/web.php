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

Route::get('/timeline', function(){
    return view('timeline');
});

Route::prefix('feedback')->group(function() {
    Route::post('feedback-api', 'FeedbackController@save')->name('save.feedback');
});

// Feedback controller
Route::post('/feedback', 'Main\FooterController@store')->name('send.feedback');


/*
|--------------------------------------------------------------------------
| COMPLETED
|--------------------------------------------------------------------------
*/
Route::get('/', 'FrontendController@home_page')->name('home.page');

Route::get('/set-locale/{lang}', 'FrontendController@set_locale')->name('set.locale');

Route::prefix('conference')->group(function() {
    Route::get('/gallery', 'Main\ConferenceController@gallery')->name('conference.gallery');
    Route::get('/download', 'Main\ConferenceController@download')->name('conference.download');
    Route::get('/contact', 'Main\ConferenceController@contact')->name('conference.contact');
    Route::post('/application/send', 'Main\ConferenceController@sendApplication')->name('conference.application.send');
    Route::get('/application', 'Main\ConferenceController@application')->name('conference.application');
    Route::get('/schedule-draft', 'Main\ConferenceController@schedule')->name('conference.schedule');
    Route::get('/about-conference', 'Main\ConferenceController@about')->name('conference.about');
    Route::get('/accomodation', 'Main\ConferenceController@accomodation')->name('conference.accomodation');
    Route::get('/', 'Main\ConferenceController@index')->name('conference');
});

Route::get('blog/{slug}', 'Blog\BlogController@getSingle')->where('slug', '[\w\d\-\_]+')->name('blog.post');


// Auth
Auth::routes();
// Logout
Route::get('/logout', 'Auth\LoginController@logout');


/*
|
|
|--------------------------------------------------------------------------
| Admin Routes (Admin Panel)
|--------------------------------------------------------------------------
|
*/

// Admin Panel Routes
Route::prefix('admin')->group(function () {

    Route::prefix('/video-library')->group(function() {
        Route::resource('/video-api-library', 'Admin\VideoLibraryController');
        Route::get('/', function() {
            return view('admin.video_library.index');
        })->name('video-library.index');
    });

    // Apps menu settings
    Route::prefix('app')->group(function () {
        Route::resource('app_1', 'Admin\App\App1Controller');

        // Padiglione 2 - Path Warm Up - App 12 - Sound Studio (Libreria Audio)
        Route::get('/sound-studio/audio-api-index', 'Admin\App\SoundStudioController@index')->name('app.sound-studio.index');
        Route::post('/sound-studio/audio-api-library', 'Admin\App\SoundStudioController@store')->name('app.sound-studio.store');
        Route::delete('/sound-studio/audio-api-delete/{id}', 'Admin\App\SoundStudioController@destroy')->name('app.sound-studio.destroy');
        Route::get('/sound-studio', 'Admin\App\SoundStudioController@view')->name('app.sound-studio.view');
    });

    // Auth
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin');

    // Nuovo pannello video
    Route::get('/video', 'Admin\VideoController@adminVideo')->name('admin.video');
    Route::get('/audio', 'Admin\AudioController@adminAudio')->name('admin.audio');
    Route::get('/images', 'Admin\ImageController@adminImage')->name('admin.image');

    // Web menu routes
    Route::resource('posts', 'Admin\PostController');
    Route::resource('media', 'Admin\MediaController', ['except' => ['show', 'create']]);
    Route::resource('categories', 'Admin\CategoryController', ['except' => ['show', 'create'] ]);
    Route::resource('tags', 'Admin\TagController', ['except' => ['show', 'create'] ]);

    // Maps settings
    Route::prefix('map')->group( function() {
        Route::prefix('api')->group(function() {
            Route::get('/{id}/edit', 'Admin\PointController@edit')->name('api.map.edit');
            Route::put('/{id}', 'Admin\PointController@update')->name('api.map.update');
            Route::post('/', 'Admin\PointController@store')->name('api.map.store');
            Route::delete('/{id}', 'Admin\PointController@destroy')->name('api.map.delete');
            Route::get('/', 'Admin\PointController@index')->name('api.map.index');
        });

        // ...admin/map/ to show index
        Route::get('/', function() {
            return view('admin.map.index');
        });
    });

    // Users menu routes
    Route::get('/admins', 'Admin\AdminController@index')->name('admin.admins.index');
    Route::resource('teachers', 'Admin\TeacherController', ['except' => ['create']]);
    Route::post('teachers/{teacher}', 'Admin\TeacherController@storeStudent')->name('teacher.store.student');
    Route::resource('students', 'Admin\StudentController', ['except' => ['create']]);
    Route::resource('users', 'Admin\UserController', ['except' => ['create']]);
    Route::resource('schools', 'Admin\SchoolController', ['except' => ['create']]);

    // Settings menu routes
    Route::resource('partners', 'Admin\PartnerController', ['except' => ['create'] ]);

    // Stats
    Route::get('/stats', 'Admin\StatsController@index')->name('stats.index');

    // Tools
    Route::get('/conference-applications', 'Admin\ToolController@indexExcel')->name('excel.index');

    // Conference gallery
    Route::prefix('conference')->group(function() {
        Route::get('/gallery', 'Admin\ConferenceController@index')->name('admin.conference.gallery.index');
        Route::post('/gallery', 'Admin\ConferenceController@store')->name('admin.conference.gallery.store');
    });

    // Translate
    Route::prefix('translate')->group(function() {
        Route::get('/languages', 'Admin\TranslateController@get_languages')->name('admin.translate.get_languages');
        Route::post('/save', 'Admin\TranslateController@save')->name('admin.translate.save');
        Route::get('/index', 'Admin\TranslateController@index')->name('admin.translate.index');
        Route::post('/get-elements', 'Admin\TranslateController@get_elements')->name('admin.translate.get_elements');
        Route::post('/get-translation', 'Admin\TranslateController@get_translation')->name('admin.translate.get_translation');
    });

    Route::prefix('apps')->group(function(){
        Route::get('/glossary', 'Admin\GlossaryController@index')->name('admin.apps.glossary.index');
        Route::post('/glossary', 'Admin\GlossaryController@store')->name('admin.apps.glossary.store');
    });

    Route::prefix('footer')->group(function(){
        Route::get('/get_credits', 'Admin\FooterController@get_credits')->name('admin.credit.get_credits');
        Route::get('/get_filmography', 'Admin\FooterController@get_filmography')->name('admin.filmography.get_filmography');
        Route::post('/save_credit', 'Admin\FooterController@save_credit')->name('admin.credit.save');
        Route::post('/save_filmography', 'Admin\FooterController@save_filmography')->name('admin.filmography.save');
        Route::post('/update_credit', 'Admin\FooterController@update_credit')->name('admin.credit.update');
        Route::post('/update_filmography', 'Admin\FooterController@update_filmography')->name('admin.filmography.update');
        Route::get('/', 'Admin\FooterController@index')->name('admin.footer');
    });
});





/*
|
|
|--------------------------------------------------------------------------
| Teacher Routes (Teacher Panel)
|--------------------------------------------------------------------------
|
*/

// Teacher Panel Teacher
Route::prefix('teacher')->group(function() {
    // Auth
    Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
    Route::post('/login', 'Auth\TeacherLoginController@login')->name('teacher.login.submit');
    Route::get('/logout', 'Auth\TeacherLoginController@logout')->name('teacher.logout');
    Route::get('/', 'TeacherController@index')->name('teacher');
    Route::get('/welcome','TeacherController@welcome')->name('teacher.welcome');

    // Video Editor
    Route::post('/video-edit/video-edit-api', 'VideoEditorController@updateEditor')->name('update.teacher.editor');
    Route::post('/audio-edit/audio-edit-api', 'AudioEditorController@updateEditor')->name('update.teacher.audio.editor');

    // Pagine Principali dei padiglioni

    // Film Specific
    Route::get('/film-specific', 'TeacherController@filmSpecific')->name('teacher.film-specific');
    Route::get('/film-specific/{category}', 'Teacher\FilmSpecificController@index')->name('teacher.film-specific.index');
    Route::get('/film-specific/{category}/{app_slug}/{token}', 'Teacher\FilmSpecificController@openSession')->name('teacher.film-specific.open.session');
    Route::get('/film-specific/{category}/{app_slug}', 'Teacher\FilmSpecificController@app')->name('teacher.film-specific.app');

    // Film Specific
    Route::get('/creative-studio', 'TeacherController@creativeStudio')->name('teacher.creative-studio');
    Route::post('/creative-studio/{category}/{app_slug}/upload', 'Teacher\CreativeStudioController@uploadVideo')->name('teacher.creative-studio.upload');
    Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Teacher\CreativeStudioController@uploadImg')->name('teacher.creative-studio.upload.img');
    Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Teacher\CreativeStudioController@openSession')->name('teacher.creative-studio.open.session');
    Route::get('/creative-studio/{category}/{app_slug}', 'Teacher\CreativeStudioController@app')->name('teacher.creative-studio.app');
    Route::get('/creative-studio/{category}', 'Teacher\CreativeStudioController@index')->name('teacher.creative-studio.index');

    Route::get('/cinema', 'TeacherController@cinemaPav')->name('teacher.cinema-pav');
    Route::get('/path_1', 'TeacherController@path')->name('teacher.path');

    // Settings
    Route::prefix('settings')->group(function() {
      Route::get('/', 'Teacher\SettingsController@index')->name('teacher.settings.index');
      Route::post('/store-student', 'Teacher\SettingsController@storeStudent')->name('teacher.student.store');
      Route::post('/save-student', 'Teacher\SettingsController@save_student')->name('teacher.settings.save_student');
      Route::post('/destroy-student', 'Teacher\SettingsController@destroy_student')->name('teacher.settings.destroy_student');
      Route::post('/delete-student', 'Teacher\SettingsController@deleteStudent')->name('teacher.student.delete');
      Route::post('/update-student', 'Teacher\SettingsController@update_student')->name('teacher.settings.update_student');
      Route::get('/get-slots', 'Teacher\SettingsController@get_slots')->name('teacher.settings.get_slots');
    });

    // Network
    Route::get('/network', 'Teacher\NetworkController@index')->name('teacher.network.index');
    Route::get('/network/{token}', 'Teacher\NetworkController@single')->name('teacher.network.single');

    // Sessioni
    Route::prefix('session')->group(function() {
      Route::get('/{teacher_id}/{app_id}', 'Teacher\SessionController@openSessions')->name('open.sessions');
      Route::post('/new', 'Teacher\SessionController@newSession')->name('new.session');
      Route::post('/update', 'Teacher\SessionController@updateSession')->name('update.session');
      Route::post('/share-approved', 'Teacher\SessionController@shareApproved')->name('teacher.session.share_approved');
      Route::post('/share', 'Teacher\SessionController@shareSession')->name('teacher.session.share');
      Route::post('/approve', 'Teacher\SessionController@approveSession')->name('teacher.session.approve');
    });


    // Notifications
    Route::prefix('notifications')->group(function() {
      Route::get('/markasread/{id}', 'Teacher\NotificationController@markAsRead')->name('teacher.notifications.markasread');
      Route::post('/markasunread', 'Teacher\NotificationController@markAsUnread')->name('teacher.notifications.markasunread');
      Route::get('/get', 'Teacher\NotificationController@getNotifications')->name('teacher.notifications.getnew');
      Route::post('/delete', 'Teacher\NotificationController@delete')->name('teacher.notifications.delete');
      Route::post('/destroy', 'Teacher\NotificationController@destroy')->name('teacher.notifications.destroy');
    });
});


/*
|
|
|--------------------------------------------------------------------------
| Student Routes (Student Panel)
|--------------------------------------------------------------------------
|
*/

// Student Panel Routes
Route::prefix('student')->group(function() {

    // Auth
    Route::get('/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
    Route::post('/login', 'Auth\StudentLoginController@login')->name('student.login.submit');
    Route::get('/logout', 'Auth\StudentLoginController@logout');
    Route::get('/', 'StudentController@index')->name('student');
    Route::get('/welcome','StudentController@welcome')->name('student.welcome');

    // Video Editor
    Route::post('/video-edit/video-edit-api', 'VideoEditorController@updateEditor')->name('update.student.editor');
    Route::post('/audio-edit/audio-edit-api', 'AudioEditorController@updateEditor')->name('update.student.audio.editor');

    // Pagine Principali dei padiglioni

    // Film Specific
    Route::get('/film-specific', 'StudentController@filmSpecific')->name('student.film-specific');
    Route::get('/film-specific/{category}', 'Student\FilmSpecificController@index')->name('student.film-specific.index');
    Route::get('/film-specific/{category}/{app_slug}/{token}', 'Student\FilmSpecificController@openSession')->name('student.film-specific.open.session');
    Route::get('/film-specific/{category}/{app_slug}', 'Student\FilmSpecificController@app')->name('student.film-specific.app');

    // Film Specific
    Route::get('/creative-studio', 'StudentController@creativeStudio')->name('student.creative-studio');
    Route::post('/creative-studio/{category}/{app_slug}/upload', 'Student\CreativeStudioController@uploadVideo')->name('student.creative-studio.upload');
    Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Student\CreativeStudioController@uploadImg')->name('student.creative-studio.upload.img');
    Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Student\CreativeStudioController@openSession')->name('student.creative-studio.open.session');
    Route::get('/creative-studio/{category}/{app_slug}', 'Student\CreativeStudioController@app')->name('student.creative-studio.app');
    Route::get('/creative-studio/{category}', 'Student\CreativeStudioController@index')->name('student.creative-studio.index');

    Route::get('/cinema', 'StudentController@cinemaPav')->name('student.cinema-pav');
    Route::get('/path_1', 'StudentController@path')->name('student.path');

    // Settings
    Route::get('/settings', 'Student\SettingsController@index')->name('student.settings.index');
    Route::post('/settings/store-student', 'Student\SettingsController@storeStudent')->name('student.student.store');
    Route::post('/settings/delete-student', 'Student\SettingsController@deleteStudent')->name('student.student.delete');

    // Network
    Route::get('/network', 'Student\NetworkController@index')->name('student.network.index');
    Route::get('/network/{token}', 'Student\NetworkController@single')->name('student.network.single');

    // Sessioni
    Route::get('/session/{student_id}/{app_id}', 'Student\SessionController@openSessions')->name('open.sessions');
    Route::post('/session/new', 'Student\SessionController@newSession')->name('new.session');
    Route::post('/session/update', 'Student\SessionController@updateSession')->name('update.session');
    Route::post('/session/share', 'Student\SessionController@shareSession')->name('student.session.share');
});

Route::get('/translate', 'Admin\TranslateController@translate')->name('test.admin');

/*
|
|
|--------------------------------------------------------------------------
| DEPRECATED
|--------------------------------------------------------------------------
|
*/

// Route::get('/posts', function () {
//   $posts = Post::with('author')->get();
//   return view('blog.list')->with('posts', $posts);
// });

// Route::get('/post/{id}', function ($id) {
//   $post = Post::findOrFail($id);
//   return view('blog.post')->with('post', $post);
// });

// Map Public Route
// Route::get('/map', 'MapController@index')->name('map.index');

// Route::get('/frame-crop', 'Admin\FrameController@index')->name('frame.index');


// Route::get('/video-test', 'Admin\VideoController@index')->name('video-test.index');
// Route::post('/video-upload', 'Admin\VideoController@upload')->name('video-test.upload');
// HTTP FOR STREAMING EDITOR
// Route::prefix('video-edit')->group(function() {
//   Route::post('video-edit-api', 'VideoEditorController@updateEditor')->name('update.editor');
//   Route::get('/', function() {
//     return view('video.index');
//   })->name('video.index');
// });
