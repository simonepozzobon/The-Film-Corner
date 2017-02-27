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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
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

        // Pre-save files to be resized
        $icon = $request->file('media')->storeAs('public/media', 'icon_'.$filename);
        $thumbnail = $request->file('media')->storeAs('public/media', 'thumbnail_'.$filename);
        $square = $request->file('media')->storeAs('public/media', 'square_'.$filename);
        $mobile = $request->file('media')->storeAs('public/media', 'mobile_'.$filename);
        $tablet = $request->file('media')->storeAs('public/media', 'tablet_'.$filename);
        $big = $request->file('media')->storeAs('public/media', 'big_'.$filename);

        // Path where files are stored according to Filesystem.php
        $path = storage_path('app/public/media');

        // Edit files
        $img_icon = Image::make($path.'/icon_'.$filename)->fit(57)->save();
        $img_thumbnail = Image::make($path.'/thumbnail_'.$filename)->fit(150)->save();
        $img_square = Image::make($path.'/square_'.$filename)->fit(400)->save();
        $img_mobile = Image::make($path.'/mobile_'.$filename)->resize( 320, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); })->save();
        $img_tablet = Image::make($path.'/tablet_'.$filename)->resize( 1024, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); })->save();
        $img_big = Image::make($path.'/big_'.$filename)->resize( 1920, null, function ($constraint) { $constraint->aspectRatio(); $constraint->upsize(); })->save();


        // Run the query
        $media = new Media;
        $media->title = $request->input('title');
        $media->url = $file;
        $media->alt = $request->input('alt');
        $media->icon = $icon;
        $media->thumbnail = $thumbnail;
        $media->square = $square;
        $media->mobile = $mobile;
        $media->tablet = $tablet;
        $media->big = $big;
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

        // Get files path
        $file = $media->url;
        $icon = $media->icon;
        $thumbnail = $media->thumbnail;
        $square = $media->square;
        $mobile = $media->mobile;
        $tablet = $media->tablet;
        $big = $media->big;

        // Delete Files
        Storage::delete($file);
        Storage::delete($icon);
        Storage::delete($thumbnail);
        Storage::delete($square);
        Storage::delete($mobile);
        Storage::delete($tablet);
        Storage::delete($big);

        // Delete Row DB
        $media->delete();

        return redirect('/admin/media')->with('status', 'Media deleted!');
    }
}
