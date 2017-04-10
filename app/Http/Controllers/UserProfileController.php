<?php

namespace App\Http\Controllers;

use App\Services\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class UserProfileController extends Controller
{

    public function show($id){
        $user = User::findOrFail($id);
        return view('user_profile/show', compact('user'));
    }

    public function block_user($id, UserRepository $users){

    	// get the users
		$user = Auth::user();
		$messenger = $users->find($id);

		// update the block table if the person being blocked isn't an admin
		if($messenger->admin == 0){
			DB::table('pm_blocks')->insert(['user_id' => $user->id, 'messenger_id' => $messenger->id]);
		} else {
			Session::flash('block_forbidden', 'Admins cannot be blocked from sending private messages to you.');
		}

		return redirect()->back();
	}

	public function unblock_user($id, UserRepository $users){

		// get the users
		$user = Auth::user();
		$messenger = $users->find($id);

		// update the block table
		DB::table('pm_blocks')->where([['messenger_id', $messenger->id], ['user_id', $user->id]])->delete();

		return redirect()->back();
	}


}
