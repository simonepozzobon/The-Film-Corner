<?php

namespace App\Http\Controllers;

use App\Media;
use App\Http\Requests\StoreMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $media = Media::all();
        return view('admin.media.index')->with('medias', $media);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedia $request)
    {
        $filename = $request->file('media')->getClientOriginalName();
        $file = $request->file('media')->storeAs('public/media', $filename);
        //$img = Image::make($request->file('media')->getRealPath());

        $path = $request->file('media');
        // Resize with image intervention
        $img_icon = Image::make($path)->resize( 300, null, function ($constraint) {
          $constraint->aspectRatio();
        });
        // Path where resized file are stored
        $store_path = public_path('storage/media/' . 'icon_'.$filename);
        // save action
        $store = $img_icon->save($store_path);

        //$img_icon = $img->resize(57,57)->storeAs('public/media', 'icon_'.$ilename);
        //$img_square = $img->resize(400,400)->storeAs('public/media', 'square_'.$ilename);
        //$img_mobile = $img->resize(320, null)->storeAs('public/media', 'mobile_'.$ilename);
        //$img_tablet = $img->resize(1024, null)->storeAs('public/media', 'tablet_'.$ilename);
        //$img_big = $img->resize(1920,null)->storeAs('public/media', 'big_'.$ilename);

        // Run the query
        $media = new Media;
        $media->title = $request->input('title');
        $media->url = $file;
        $media->alt = $request->input('alt');
        $media->icon = $store_path;
        $media->square = $store_path;
        $media->mobile = $store_path;
        $media->tablet = $store_path;
        $media->big = $store_path;
        $media->save();

        return redirect('/admin/media')->with('status', 'New media uploaded!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $file = $media->url;
        Storage::delete($file);
        $media->delete();
        return redirect('/admin/media')->with('status', 'Media deleted!');
    }
}
