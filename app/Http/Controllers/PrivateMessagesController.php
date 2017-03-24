<?php

namespace App\Http\Controllers;

use App\PrivateMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create($id){
        $recipient = User::findOrFail($id);
        return view('private_messages/create', compact('recipient'));
    }

    public function store(PrivateMessage $pm, $id, Request $request){
        $message = $request['content'];
        $recipient = User::findOrFail($id);
        $pm->send_message($recipient, $message);
        return redirect()->back();
    }
}
