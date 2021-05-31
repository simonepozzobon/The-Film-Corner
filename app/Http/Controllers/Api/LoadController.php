<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\App;
use App\Utility;
use App\Session;
use App\Network;
use App\AppSection;
use App\AppCategory;
use App\MediaCouples;
use App\MediaSubCategory;

use App\Notifications\SharedSession;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LoadController extends Controller
{
    public function test()
    {
        $request = new Request();
        $request->replace(
            [
                'token' => '5d3e0f4057d6c'
            ]
        );

        $result = $this->share_to_network($request);
        dd($result);
    }

    public function load_assets($slug, $token = false)
    {
        $app = App::where('slug', $slug)->with('category.section')->first();

        if ($app) {
            // se non c'è nessun token, creo una nuova sessione
            if (!$token || $token == false) {
                $session = new Session();
                $session->user_id = Auth::user() ? Auth::user()->id : 1;
                $session->app_id = $app->id;
                $session->title = 'empty';
                $session->token = uniqid();
                $session->content = json_encode([]);
                $session->save();
                $session->refresh();
                $session->app = $session->app;
            } else {
                $session = Session::where('token', $token)->with('app')->first();
                //
                // return [
                //     'success' => false,
                //     'error' => 'session error',
                //     'slug' => $slug,
                //     'token' => $token,
                // ];
            }

            $assets = [];
            switch ($app->slug) {

                case 'frame-composer':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => true,
                        'library' => $images,
                    ];
                    break;

                case 'frame-crop':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => false,
                        'library' => $images,
                    ];
                    break;

                case 'types-of-images':
                    $media_couples = MediaCouples::with('left', 'right')->get();
                    $media_couples = $media_couples->transform(
                        function ($item, $key) {
                            $item->leftSrc = Storage::disk('local')->url($item->left->landscape);
                            $item->rightSrc = Storage::disk('local')->url($item->right->landscape);
                            return $item;
                        }
                    );
                    $random = $media_couples->random();

                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => false,
                        'library' => $media_couples,
                        'random' => $random,
                    ];
                    break;

                case 'parallel-action':
                    $videos = MediaSubCategory::where('app_id', 4)->with('videos')->get();
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => true,
                        'library' => $videos,
                    ];
                    break;

                case 'offscreen':
                    $videos = $app->videos()->get();
                    $videos = $videos->transform(
                        function ($video, $key) {
                            $video->videoSrc = Storage::disk('local')->url($video->src);
                            return $video;
                        }
                    );
                    $assets = [
                        'type' => 'videos',
                        'hasSubLibraries' => false,
                        'library' => $videos,
                    ];
                    break;

                case 'whats-going-on':
                    $audios = $app->audios()->get();
                    $audios = $audios->transform(
                        function ($audio, $key) {
                            $audio->audioSrc = Storage::disk('local')->url($audio->src);
                            return $audio;
                        }
                    );
                    $assets = [
                        'type' => 'audios',
                        'hasSubLibraries' => false,
                        'library' => $audios,
                    ];
                    break;

                case 'soundscapes':
                    $images = $app->medias()->get();
                    $audios = $app->audios()->get();
                    $libraries = collect(
                        [
                            [
                                'id' => 1,
                                'name' => 'Audio',
                                'type' => 'audios',
                                'audios' => $audios,
                            ],
                            [
                                'id' => 2,
                                'name' => 'Images',
                                'type' => 'images',
                                'medias' => $images,
                            ]
                        ]
                    );

                    $assets = [
                        'type' => 'mix',
                        'hasSubLibraries' => true,
                        'library' => $libraries,
                    ];
                    break;

                case 'active-offscreen':
                    $videos = $app->videos()->get();
                    $videos = $videos->transform(
                        function ($video, $key) {
                            $video->videoSrc = Storage::disk('local')->url($video->src);
                            return $video;
                        }
                    );

                    $libraries = collect(
                        [
                            [
                                'id' => 1,
                                'name' => 'Video',
                                'type' => 'videos',
                                'videos' => $videos,
                            ],
                            [
                                'id' => 2,
                                'name' => 'Upload',
                                'type' => 'uploads',
                                'videos' => [],
                            ]
                        ]
                    );

                    $assets = [
                        'type' => 'mix',
                        'hasSubLibraries' => true,
                        'library' => $libraries,
                    ];
                    break;

                case 'active-parallel-action':
                    $videos = MediaSubCategory::where('app_id', 10)->with('videos')->get();
                    $videos = $videos->transform(
                        function ($library, $key) {
                            $library->type = 'videos';
                            return $library;
                        }
                    );
                    $uploads = collect(
                        [
                            [
                                'id' => 99,
                                'name' => 'Upload',
                                'type' => 'uploads',
                                'videos' => [],
                            ]
                        ]
                    );
                    $libraries = $videos->concat($uploads);

                    $assets = [
                        'type' => 'mix',
                        'hasSubLibraries' => true,
                        'library' => $libraries,
                    ];
                    break;

                case 'sound-studio':
                    $audios = MediaSubCategory::where('app_id', 12)->with('audios')->get();
                    $video = $app->videos()->inRandomOrder()->first();
                    $src = $video->src;
                    $assets = [
                        'type' => 'audios',
                        'hasSubLibraries' => true,
                        'library' => $audios,
                        'video' => $src
                    ];
                    break;

                case 'character-builder':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => true,
                        'library' => $images,
                    ];
                    break;

                case 'storytelling':
                    $images = $app->mediaCategory()->with('medias')->get();
                    $assets = [
                        'type' => 'images',
                        'hasSubLibraries' => true,
                        'library' => $images,
                    ];
                    break;

                case 'lumiere-minute':
                    // fatta
                    break;
                case 'make-your-own-film':
                    // fatta
                    break;
            }

            return [
                'success' => true,
                'app' => $app,
                'assets' => $assets,
                'session' => $session,
            ];
        } else {
            return [
                'success' => false,
                'error' => 404,
                'slug' => $slug,
            ];
        }
    }

    public function save_session(Request $request)
    {
        $session = Session::find($request->id);

        foreach ($session->getAttributes() as $key => $value) {
            switch ($key) {
                case 'content':
                    $session->content = json_encode($request->content);
                    break;

                default:
                    $session->{$key} = $request{
                    $key};
                    break;
            }
        }

        $session->is_empty = 0;
        $session->save();

        return [
            'success' => true,
            'request' => $request->all(),
            'session' => $session,
        ];
    }

    public function delete_session($token, $clean)
    {
        $params = [
            ['token', '=', $token],
        ];

        if ($clean == 'true') {
            $params = [
                ['token', '=', $token],
                ['is_empty', '=', 1],
            ];
        }

        $session = Session::where($params)->first();
        if ($session) {
            $session->delete();
            return [
                'success' => true,
            ];
        }

        return [
            'success' => false,
            'error' => 404,
        ];
    }

    public function contest_upload(Request $request)
    {
        $utility = new Utility;
        $file = $request->file('media');
        $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();

        $app_slug = $request->slug;
        $category_slug = $request->slug;
        $user = Auth::user();

        $filename = uniqid();

        $videoStore = $utility->storeVideo($file, $filename, $ext, 'apps/' . $category_slug . '/' . $app_slug . '/' . $user->id . '/');

        return response(
            [
                'name' => $title,
                'duration' => $videoStore['duration'],
                // 'video_id' => $video->id,
                'img' => Storage::disk('local')->url($videoStore['img']),
                'src' => $videoStore['src']
            ]
        );
    }

    public function upload_asset(Request $request)
    {
        $file = $request->file('file');
        $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = uniqid();
        $ext = $file->getClientOriginalExtension();
        $app = App::where('id', $request->app_id)->with('category')->first();
        $app_slug = $app->slug;
        $category_slug = $app->category->slug;
        $user = Auth::user();
        $utility = new Utility();

        $format = $this->check_format($ext);

        if ($format == 'video') {
            $video_store = $utility->storeVideo($file, $filename, $ext, 'apps/' . $category_slug . '/' . $app_slug . '/' . $user->id . '/');
            return [
                'success' => true,
                'type' => 'video',
                'title' => $title,
                'img' => $video_store['img'],
                'duration' => $video_store['duration'],
                'src' => Storage::disk('local')->url($video_store['src']),
            ];
        } elseif ($format == 'audio') {
            $audio_store = $utility->storeAudio($file, $filename, $ext, 'apps/' . $category_slug . '/' . $app_slug . '/' . $user->id . '/');
            return [
                'success' => true,
                'type' => 'audio',
                'title' => $title,
                'duration' => $audio_store['duration'],
                'src' => Storage::disk('local')->url($audio_store['src']),
            ];
        }
    }

    public function check_format($ext)
    {
        $video = ['mp4', 'avi', 'mov', 'mpeg', '3gp', 'm4v', 'mkv', 'flv', 'FLV', 'MP4', 'MKV', 'MOV', 'AVI', 'MPEG', 'MPEG'];
        $audio = ['wav', 'mp3', 'WAV', 'MP3', 'aiff'];

        if (in_array($ext, $video)) {
            return 'video';
        } elseif (in_array($ext, $audio)) {
            return 'audio';
        } else {
            return false;
        }
    }

    public function share_to_teacher(Request $request)
    {
        $session = Session::where('token', $request->token)->first();

        if ($session) {
            if ($session->teacher_shared == 0) {
                $session->teacher_shared = 1;
                $session->save();

                $student = $session->user;

                // trova l'insegnante
                $teacher = $student->teacher->first();
                $teacher->notify(new SharedSession($session, $student));

                return [
                    'success' => true,
                    'session' => $session
                ];
            }

            return [
                'success' => false,
                'error' => 'Session already shared'
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Session not found'
            ];
        }
    }

    public function share_to_network(Request $request)
    {
        $session = Session::where('token', $request->token)->first();
        $notification = Auth::user()->notifications()->where('id', $request->notification_id)->first();

        if ($notification) {
            $notification->delete();
        }

        if ($session) {
            if ($session->is_shared == 0) {
                $session->teacher_approved = 1;
                $session->is_shared = 1;
                $session->save();

                $user = Auth::user();

                $content = $session->format_for_share();
                $data = [
                    'app_id' => $session->app->id,
                    'user_id' => $session->user->id,
                    'title' => $session->title,
                    'token' => $request->token,
                    'content' => collect($content),
                ];

                $network = Network::create($data);

                return [
                    'success' => true,
                    'session' => $session,
                    'network' => $network,
                ];
            }

            return [
                'success' => false,
                'error' => 'Session already shared'
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Session not found'
            ];
        }
    }
}
