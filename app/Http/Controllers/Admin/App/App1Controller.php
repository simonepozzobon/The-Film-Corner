<?php

namespace App\Http\Controllers\Admin\App;

use App\Models\Apps\App1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class App1Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => 'logout']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frames = App1::all();
        return view('admin.apps.1.index')->with('frames', $frames);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apps.1.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, array(
        'name' => 'required',
        'description' => 'required',
      ));

      $filename = $request->file('frame')->getClientOriginalName();
      $file = $request->file('frame')->storeAs('public/apps/app_1', $filename);
      $path = storage_path('app/public/apps/app_1');
      $img_square = Image::make($path.'/'.$filename)->fit(500)->save();

      $frame = new App1;
      $frame->name = $request->input('name');
      $frame->description = $request->input('description');
      $frame->frame = $file;
      $frame->save();
      $request->session()->flash('succes', 'New frame created!');
      return redirect()->route('app_1.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $frame = App1::find($id);
        return view('admin.apps.1.show')->with('frame', $frame);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $frame = App1::find($id);
        return view('admin.apps.1.edit')->with('frame', $frame);
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
        //
    }
}
