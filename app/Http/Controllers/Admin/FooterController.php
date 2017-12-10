<?php

namespace App\Http\Controllers\Admin;

use App\Credit;
use App\Filmography;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterController extends Controller
{
    /*
     * Route GET /admin/footer/
     * return view with the Vue component
     * @Array
    */

    public function index()
    {
        return view('admin.footer.index');
    }


    /*
     * Route GET /admin/footer/get_credits
     * return list of credits for the entire library in the project
     * @Array
    */

    public function get_credits()
    {
        $credits = Credit::all();
        return response($credits);
    }


    /*
     * Route GET /admin/footer/get_filmography
     * return list of filmography for the entire library in the project
     * @Array
    */

    public function get_filmography()
    {
        $filmographies = Filmography::all();
        return response($filmographies);
    }


    /*
     * Route POST /admin/footer/save_filmography
     * store a new filmography and return the stored filmography as object
    */

    public function save_filmography(Request $request)
    {
        $filmography = new Filmography();
        $filmography->title = $request->title;
        $filmography->description = $request->description;
        $filmography->save();

        return response($filmography);
    }


    /*
     * Route POST /admin/footer/save_credit
     * store a new credit and return the stored credit as object
    */

    public function save_credit(Request $request)
    {
        $credit = new Credit();
        $credit->name = $request->name;
        $credit->role = $request->role;
        $credit->save();

        return response($credit);
    }


    /*
     * Route POST /admin/footer/update_filmography
     * update a new filmography and return the updated filmography as object
    */

    public function update_filmography(Request $request)
    {
        $filmography = Filmography::find($request->id);
        $filmography->title = $request->title;
        $filmography->description = $request->description;
        $filmography->save();

        return response($filmography);
    }


    /*
     * Route POST /admin/footer/update_credit
     * update a new credit and return the updated credit as object
    */

    public function update_credit(Request $request)
    {
        $credit = Credit::find($request->id);
        $credit->name = $request->name;
        $credit->role = $request->role;
        $credit->save();

        return response($credit);
    }
}
