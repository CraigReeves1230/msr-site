<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wrestler;
use App\Image;
use App\AltName;

class AdminWrestlersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create_wrestler(){
        return view('admin.wrestlers.create_wrestler');
    }

    public function store_wrestler(Request $request){

        // validations
        $this->validate($request, ['name' => 'required|unique:wrestlers|max:50', 'image' => 'required']);

        // save wrestler
        $wrestler = new Wrestler;
        $wrestler->save_wrestler($request);

        return redirect('admin/all_wrestlers');
    }

    public function all_wrestlers(){
        $wrestlers = Wrestler::orderBy('name', 'asc')->paginate(10);
        return view('admin.wrestlers.all_wrestlers', compact('wrestlers'));
    }

    public function search_wrestlers(Request $request){
        $search_query = $request['search_query'];
        $wrestlers = Wrestler::where('name', 'LIKE', "%$search_query%")->get();
        if($search_query == "") {
            $wrestlers = Wrestler::orderBy('name', 'asc')->get();
        }
        return view('admin.wrestlers.all_wrestlers', compact('wrestlers'));
    }

    public function edit_wrestler($id){
        $wrestler = Wrestler::findOrFail($id);
        return view('admin.wrestlers.edit_wrestler', compact('wrestler'));
    }

    public function update_wrestler(Request $request, $id){

        // validations
        $this->validate($request, ['name' => 'required|max:50']);

        // update wrestler
        $wrestler = Wrestler::findOrFail($id);
        $wrestler->update_wrestler($request);

        return redirect('admin/all_wrestlers');
    }

    public function destroy($id){

        // find wrestler
        $wrestler = Wrestler::findOrFail($id);

        // delete wrestler
        $wrestler->delete_wrestler();

        return redirect('admin/all_wrestlers');
    }
}

