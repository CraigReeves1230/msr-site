<?php

namespace App\Http\Controllers;

use App\Services\Repositories\WrestlerRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wrestler;
use App\Image;
use App\AltName;

class AdminWrestlersController extends Controller
{

    protected $wrestler_repository;

    public function __construct(WrestlerRepository $wrestler_repository)
    {
        $this->middleware('admin');
        $this->wrestler_repository = $wrestler_repository;
    }

    public function create_wrestler(){
        return view('admin.wrestlers.create_wrestler');
    }

    public function store_wrestler(Request $request){

        // validations
        $this->validate($request, ['name' => 'required|unique:wrestlers|max:50', 'image' => 'required']);

        // save wrestler
        $this->wrestler_repository->save($request);

        return redirect('admin/all_wrestlers');
    }

    public function all_wrestlers(){
        $wrestlers = $this->wrestler_repository->all('paginate', 10);
        return view('admin.wrestlers.all_wrestlers', compact('wrestlers'));
    }

    public function search_wrestlers(Request $request){
        $search_query = $request['search_query'];
        $wrestlers = $this->wrestler_repository->where('name', 'LIKE', "%$search_query%", 'paginate', 10);
        if($search_query == "") {
            $wrestlers = $this->wrestler_repository->all('paginate', 10);
        }
        return view('admin.wrestlers.all_wrestlers', compact('wrestlers'));
    }

    public function edit_wrestler($id){
        $wrestler = $this->wrestler_repository->find($id);
        return view('admin.wrestlers.edit_wrestler', compact('wrestler'));
    }

    public function update_wrestler(Request $request, $id){

        // validations
        $this->validate($request, ['name' => 'required|max:50']);

        // update wrestler
        $this->wrestler_repository->update($id, $request);

        return redirect('admin/all_wrestlers');
    }

    public function destroy($id){

        // delete wrestler
        $this->wrestler_repository->delete($id);

        return redirect('admin/all_wrestlers');
    }
}

