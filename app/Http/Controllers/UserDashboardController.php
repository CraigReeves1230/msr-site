<?php

namespace App\Http\Controllers;


use App\Services\RatingConverter;
use App\Services\Repositories\CommentsRepository;
use App\Services\Repositories\UserRepository;
use App\Services\Repositories\WrestlerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    protected $user_repository;
    protected $comments_repository;

    public function __construct(UserRepository $user_repository, CommentsRepository $comments_repository){
        $this->middleware('auth');
        $this->user_repository = $user_repository;
        $this->comments_repository = $comments_repository;
    }

    public function index(){
        $user = Auth::user();
		$recent_comments = $user->comments()->orderBy('id', 'desc')->limit(4)->get();
        return view('user_dashboard/index', compact('user', 'recent_comments'));
    }

    public function my_wrestlers(RatingConverter $converter){
        $user = Auth::user();
        $wrestlers = $user->wrestlers_paginated(5);
        return view('user_dashboard/my_wrestlers/my_ratings', compact('user', 'wrestlers', 'converter'));
    }

    public function my_favorites(){
        $user = Auth::user();
        $wrestlers = $user->favorites_paginated(5);
        return view('user_dashboard/my_wrestlers/favorites', compact('user', 'wrestlers'));
    }

    public function remove_favorite($id){
    	$user = Auth::user();

    	// remove record
		DB::table('wrestler_favorites')->where([['user_id', $user->id], ['wrestler_id', $id]])->delete();

		//refresh
		return redirect()->back();
	}

    public function edit_user(){
        $user = Auth::user();
        return view('user_dashboard/edit_user', compact('user'));
    }

    public function update_user(Request $request){

        // validate name and image no matter what
        $this->validate($request, ['name' => 'required|max:255', 'image' => 'image|max:150|mimes:jpeg,png']);

        // validate email only if it is changed
        if($request['email'] != $request['old_email']){
            $this->validate($request, ['email' => 'required|email|max:255|unique:users']);
        }

        // validate password only if it is changed
        if(!empty($request['password']) || !empty($request['password_confirmation'])){
            $this->validate($request, ['password' => 'required|min:6|confirmed']);
        }

        // get logged in user and store request data into array
        $user = Auth::user();
        $data = $request->all();

        // upload image if new one was uploaded
        if($file = $request->file('image')){
            $image_name = $file->getClientOriginalName();
            $file->move('img', $image_name);
            $data['image'] = $image_name;
        }

        $this->user_repository->update($user->id, $data);
        return redirect('/user_dashboard');
    }

    public function delete_rating($id, WrestlerRepository $wrestlers){

        // set user variable
        $user = Auth::user();

        // get delete rating
        $user->ratings()->where('wrestler_id', $id)->delete();

        return redirect()->back();

    }
}
