<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Guest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Validation\Validator;

class GuestController extends Controller
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
        // $guests = Guest::all();
        // $schools = School::all();
        // return view('admin.guests.index')
        //               ->with('guests', $guests)
        //               ->with('schools', $schools);
        return view('admin.guests.index');
    }

    public function get_guests()
    {
        $guests = Guest::all();
        return response($guests);
    }

    public function save(Request $request)
    {
        $guest = Guest::find($request->id);
        $guest->name = $request->name;
        $guest->email = $request->email;

        if ($request->password != null) {
            $guest->password = Hash::make($request->password);
        }

        $guest->save();

        return response($guest);
    }

    public function new(Request $request)
    {
        $guest = new Guest();
        $guest->name = $request->name;
        $guest->email = $request->email;
        $guest->password = Hash::make($request->password);
        $guest->save();

        return response($guest);
    }

    public function destroy(Request $request)
    {
        $guest = Guest::find($request->id);
        $guest->delete();
        return response([
            'status' => 'deleted'
        ]);
    }
}
