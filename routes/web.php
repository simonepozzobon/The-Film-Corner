<?php

use App\Post;
use App\Partner;

// use Symfony\Component\Debug\Debug;
// Debug::enable();

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| PROGRESS
|--------------------------------------------------------------------------
*/

Route::get('/frame-crop', 'Admin\FrameController@index')->name('frame.index');


Route::get('/video-test', 'Admin\VideoController@index')->name('video-test.index');
Route::post('/video-upload', 'Admin\VideoController@upload')->name('video-test.upload');
// HTTP FOR STREAMING EDITOR
Route::prefix('video-edit')->group(function() {
  Route::post('video-edit-api', 'VideoEditorController@updateEditor')->name('update.editor');
  Route::get('/', function() {
    return view('video.index');
  })->name('video.index');
});

Route::prefix('feedback')->group(function() {
  Route::post('feedback-api', 'FeedbackController@save')->name('save.feedback');
});

/*
|--------------------------------------------------------------------------
| NEED UPDATE
|--------------------------------------------------------------------------
*/

// Feedback controller
Route::post('/feedback', 'Main\FooterController@store')->name('send.feedback');

// need to create a controller for these maybe Main or FrontendController
Route::get('/', function () {
    $posts = Post::where('category_id', '=', 1)->latest()->limit(5)->get();
    $partners = Partner::all();
    return view('new')
                ->with('posts', $posts)
                ->with('partners', $partners);
});

Route::get('/posts', function () {
  $posts = Post::with('author')->get();
  return view('blog.list')->with('posts', $posts);
});

Route::get('/post/{id}', function ($id) {
  $post = Post::findOrFail($id);
  return view('blog.post')->with('post', $post);
});


/*
|--------------------------------------------------------------------------
| DONE
|--------------------------------------------------------------------------
*/

Route::prefix('conference')->group(function() {
  Route::get('/download', 'Main\ConferenceController@download')->name('conference.download');
  Route::get('/contact', 'Main\ConferenceController@contact')->name('conference.contact');
  Route::post('/application/send', 'Main\ConferenceController@sendApplication')->name('conference.application.send');
  Route::get('/application', 'Main\ConferenceController@application')->name('conference.application');
  Route::get('/schedule-draft', 'Main\ConferenceController@schedule')->name('conference.schedule');
  Route::get('/about-conference', 'Main\ConferenceController@about')->name('conference.about');
  Route::get('/', 'Main\ConferenceController@index')->name('conference');
});

Route::get('blog/{slug}', 'Blog\BlogController@getSingle')->where('slug', '[\w\d\-\_]+')->name('blog.post');

// Map Public Route
Route::get('/map', 'MapController@index')->name('map.index');
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

  /*
  |--------------------------------------------------------------------------
  | WORKING
  |--------------------------------------------------------------------------
  | - add video library to manage all the video in once then assign to apps.
  */
  Route::prefix('/video-library')->group(function() {
    Route::resource('/video-api-library', 'Admin\VideoLibraryController');
    Route::get('/', function() {
      return view('admin.video_library.index');
    })->name('video-library.index');
  });

  /*
  |--------------------------------------------------------------------------
  | NEED UPDATE
  |--------------------------------------------------------------------------
  */

  // Apps menu settings
  Route::prefix('app')->group(function () {
    Route::resource('app_1', 'Admin\App\App1Controller');
  });

  /*
  |--------------------------------------------------------------------------
  | DONE
  |--------------------------------------------------------------------------
  */
  // Auth
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
  Route::get('/', 'AdminController@index')->name('admin');

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

  // Apps
  Route::get('/app', 'AppController@firstApp')->name('app.first');
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

  // Pagine Principali dei padiglioni
  Route::get('/film-specific', 'StudentController@filmSpecific')->name('student.film-specific');
  Route::get('/cinema', 'StudentController@cinemaPav')->name('student.cinema-pav');
  Route::get('/creative-studio', 'StudentController@creativeStudio')->name('student.creative-studio');
  
});
