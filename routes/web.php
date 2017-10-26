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
Route::get('/test', function(){

  event(new UserSignin());
  $user = Auth::guard('teacher')->user();
  if ($user == null) {
    $user = Auth::guard('student')->user();
    $model = 'student';
    $contacts = $user->teacher()->get();
  } else {
    $contacts = $user->students()->get();
    $model = 'teacher';
  }

  return view('test', compact('user', 'model', 'contacts'));
});

Route::prefix('feedback')->group(function() {
  Route::post('feedback-api', 'FeedbackController@save')->name('save.feedback');
});

// Feedback controller
Route::post('/feedback', 'Main\FooterController@store')->name('send.feedback');

// need to create a controller for these maybe Main or FrontendController
Route::get('/', function () {
    $posts = Post::where('category_id', '=', 1)->latest()->limit(5)->get();
    $partners = Partner::all();
    $colors = [
      0 => ['#f5db5e', '#e9c845'],
      1 => ['#d8ef8f', '#b7cc5e'],
      2 => ['#f4c490', '#e8a360'],
      3 => ['#d9f5fc', '#a6dbe2'],
    ];

    $counter = 0;
    foreach ($posts as $key => $post) {
      $post->colors = $colors[$counter];
      $counter++;

      if ($counter % 4 == 0) {
        $counter = 0;
      }
    }
    return view('new', compact('posts', 'partners', 'colors'));
});

/*
|--------------------------------------------------------------------------
| COMPLETED
|--------------------------------------------------------------------------
*/

Route::prefix('conference')->group(function() {
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
  Route::get('/creative-studio/{category}', 'Teacher\CreativeStudioController@index')->name('teacher.creative-studio.index');
  Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Teacher\CreativeStudioController@openSession')->name('teacher.creative-studio.open.session');
  Route::get('/creative-studio/{category}/{app_slug}', 'Teacher\CreativeStudioController@app')->name('teacher.creative-studio.app');
  Route::post('/creative-studio/{category}/{app_slug}/upload', 'Teacher\CreativeStudioController@uploadVideo')->name('teacher.creative-studio.upload');
  Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Teacher\CreativeStudioController@uploadImg')->name('teacher.creative-studio.upload.img');

  Route::get('/cinema', 'TeacherController@cinemaPav')->name('teacher.cinema-pav');
  Route::get('/path_1', 'TeacherController@path')->name('teacher.path');

  // Settings
  Route::get('/settings', 'Teacher\SettingsController@index')->name('teacher.settings.index');
  Route::post('/settings/store-student', 'Teacher\SettingsController@storeStudent')->name('teacher.student.store');
  Route::post('/settings/delete-student', 'Teacher\SettingsController@deleteStudent')->name('teacher.student.delete');

  // Network
  Route::get('/network', 'Teacher\NetworkController@index')->name('teacher.network.index');

  // Sessioni
  Route::get('/session/{teacher_id}/{app_id}', 'Teacher\SessionController@openSessions')->name('open.sessions');
  Route::post('/session/new', 'Teacher\SessionController@newSession')->name('new.session');
  Route::post('/session/update', 'Teacher\SessionController@updateSession')->name('update.session');
  Route::post('/session/share', 'Teacher\SessionController@shareSession')->name('teacher.session.share');

  // Notifications
  Route::get('/notifications/markasread/{id}', 'Teacher\NotificationController@markAsRead')->name('teacher.notifications.markasread');
  Route::get('/notifications/get', 'Teacher\NotificationController@getNotifications')->name('teacher.notifications.getnew');
  Route::post('/notifications/delete', 'Teacher\NotificationController@delete')->name('teacher.notifications.delete');
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
  Route::get('/creative-studio/{category}', 'Student\CreativeStudioController@index')->name('student.creative-studio.index');
  Route::get('/creative-studio/{category}/{app_slug}/{token}', 'Student\CreativeStudioController@openSession')->name('student.creative-studio.open.session');
  Route::get('/creative-studio/{category}/{app_slug}', 'Student\CreativeStudioController@app')->name('student.creative-studio.app');
  Route::post('/creative-studio/{category}/{app_slug}/upload', 'Student\CreativeStudioController@uploadVideo')->name('student.creative-studio.upload');
  Route::post('/creative-studio/{category}/{app_slug}/upload-img', 'Student\CreativeStudioController@uploadImg')->name('student.creative-studio.upload.img');

  Route::get('/cinema', 'StudentController@cinemaPav')->name('student.cinema-pav');
  Route::get('/path_1', 'StudentController@path')->name('student.path');

  // Settings
  Route::get('/settings', 'Student\SettingsController@index')->name('student.settings.index');
  Route::post('/settings/store-student', 'Student\SettingsController@storeStudent')->name('student.student.store');
  Route::post('/settings/delete-student', 'Student\SettingsController@deleteStudent')->name('student.student.delete');

  // Network
  Route::get('/network', 'Student\NetworkController@index')->name('student.network.index');

  // Sessioni
  Route::get('/session/{student_id}/{app_id}', 'Student\SessionController@openSessions')->name('open.sessions');
  Route::post('/session/new', 'Student\SessionController@newSession')->name('new.session');
  Route::post('/session/update', 'Student\SessionController@updateSession')->name('update.session');
  Route::post('/session/share', 'Student\SessionController@shareSession')->name('student.session.share');

});


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
