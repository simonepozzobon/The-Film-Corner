<?php

namespace App\Http\Controllers\Admin;

use App\Media;
use App\Utility;
use App\StaticPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ConferenceController extends Controller
{
    public function index()
    {
      $static_page = StaticPage::where('slug', '=', 'conference')->first();
      $images = $static_page->medias()->get();

      return view('admin.conference.gallery.index', compact('images'));
    }

    public function store(Request $r)
    {
      $utility = new Utility;
      $file = $r->file('media');
      $filename = pathinfo($r->file('media')->getClientOriginalName(), PATHINFO_FILENAME);
      $ext = $r->file('media')->getClientOriginalExtension();

      $check = $utility->verifyExt($ext, ['image']);

      if ($check) {
          $destFolder = 'apps/media/conference/gallery';

          $library = $utility->storeImg($file, $filename, $destFolder);

          $media = new Media;
          $media->category_id = 1;
          $media->title = 'The Film Corner International Conference';
          $media->src = preg_replace('/public\//', '',$library['src']);
          $media->thumb = preg_replace('/public\//', '',$library['thumb']);
          $media->landscape = preg_replace('/public\//', '',$library['landscape']);
          $media->portrait = preg_replace('/public\//', '',$library['portrait']);
          $media->save();

          $static_page = StaticPage::where('slug', '=', 'conference')->first();
          $static_page->medias()->save($media);
          $r->session()->flash('success', 'New media upload!');
          return redirect()->route('admin.conference.gallery.index');
        } else
        {
          $r->session()->flash('danger', 'Format Not supported!');
          return redirect()->route('admin.conference.gallery.index');

        }


    }
}
