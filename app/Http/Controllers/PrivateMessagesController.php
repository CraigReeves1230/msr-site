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

    public function index(){
        $user = Auth::user();
        $private_messages = $user->private_messages()->orderBy('id', 'desc')->get();
        return view('private_messages/inbox', compact('user', 'private_messages'));
    }

    public function show($id){
        $user = Auth::user();
        $private_message = PrivateMessage::findOrFail($id);
        return view('private_messages/show', compact('user', 'private_message'));
    }

}
