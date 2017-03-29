<?php

namespace App\Http\Controllers;

use App\MatchRater;
use App\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        return view('user_dashboard/index', compact('user'));
    }

    public function my_wrestlers(){
        $user = Auth::user();
        $wrestlers = $user->wrestlers_paginated(5);
        return view('user_dashboard/my_wrestlers/my_ratings', compact('user', 'wrestlers'));
    }

    public function my_favorites(){
        $user = Auth::user();
        $wrestlers = $user->favorites_paginated(5);
        return view('user_dashboard/my_wrestlers/favorites', compact('user', 'wrestlers'));
    }

    public function edit_user(){
        $user = Auth::user();
        return view('user_dashboard/edit_user', compact('user'));
    }

    public function update_user(Request $request){

        // validate name no matter what
        $this->validate($request, ['name' => 'required|max:255']);

        // validate email only if it is changed
        if($request['email'] != $request['old_email']){
            $this->validate($request, ['email' => 'required|email|max:255|unique:users']);
        }

        // validate password only if it is changed
        if(!empty($request['password'])){
            $this->validate($request, ['password' => 'required|min:6|confirmed']);
        }

        // get logged in user
        $user = Auth::user();

        $user->update_user($request);
        return redirect('/user_dashboard');
    }
}
