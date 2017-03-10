<?php

namespace App\Http\Controllers\Admin;

use Purifier;
use App\Partner;
use Illuminate\Http\Request;
use App\Http\Requests\StorePartner;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PartnerController extends Controller
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
        $partners = Partner::all();
        return view('admin.partners.index')->with('partners', $partners);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartner $request)
    {
        $filename = $request->file('media')->getClientOriginalName();
        $partnerName = $request->input('id_tag');
        $file = $request->file('media')->storeAs('public/partners/'.$partnerName, $filename);

        // Path where files are stored according to Filesystem.php
        $path = storage_path('app/public/partners/'.$partnerName);

        // Edit files
        $img_square = Image::make($path.'/'.$filename)->fit(500)->save();

        $partner = new Partner;
        $partner->name = $request->input('name');
        $partner->logo_url = $file;
        $partner->id_tag = $request->input('id_tag');
        $partner->location = $request->input('location');
        $partner->url = $request->input('url');
        $partner->description = Purifier::clean($request->input('description'), 'youtube');
        $partner->save();

        $request->session()->flash('success', 'New partner created!');

        return redirect()->route('partners.index');
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
        $partner = Partner::findOrFail($id);

        // Get files path
        $file = $partner->logo;

        // Delete Files
        Storage::delete($file);

        // Delete Row DB
        $partner->delete();

        $request->session()->flash('success', 'Partner deleted!');

        return redirect()->route('partners.index');
    }
}
