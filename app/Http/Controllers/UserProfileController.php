<?php

namespace App\Http\Controllers;

use App\MatchRater;
use App\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        return view('main/my_profile/index', compact('user'));
    }

    public function my_wrestlers(){
        $user = Auth::user();
        $wrestlers = $user->wrestlers();
        return view('main/my_profile/my_wrestlers/my_ratings', compact('user', 'wrestlers'));
    }
}
