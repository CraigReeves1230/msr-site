<?php

namespace App\Http\Controllers;

use App\PrivateMessage;
use App\PrivateMessageReply;
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

        // validations
        $this->validate($request, ['content' => 'required']);

        $message = $request['content'];
        $author = Auth::user();
        $recipient = User::findOrFail($id);
        $pm->send_message($author, $recipient, $message);
        return redirect('user_dashboard/messages');
    }

    public function see_messages(){
        $user = Auth::user();

        // make it to where new messages is zero
        $user->new_messages = 0;
        $user->save();

        // get all private messages that were sent to user or by user
        $private_messages = PrivateMessage::where([  ['user_id', $user->id], ['trash_id', '<>', $user->id]   ])
            ->orWhere([ ['author_id', $user->id], ['trash_id', '<>', $user->id] ])
            ->orderBy('id', 'desc')->get();

        return view('private_messages/index', compact('user', 'private_messages'));
    }

    public function show($id){
        $user = Auth::user();
        $private_message = PrivateMessage::findOrFail($id);

        // only allow either the author or recipient to go on
        if( ($private_message->user_id == $user->id) || ($private_message->author_id == $user->id) ) {

            $private_message_replies = PrivateMessageReply::orderBy('id', 'asc')->where('private_message_id', $private_message->id)->get();
            return view('private_messages/show', compact('user', 'private_message', 'private_message_replies'));
        } else {
            return redirect('/');
        }
    }

    public function send_reply(PrivateMessageReply $reply, Request $request){

        //handle validations
        $this->validate($request, ['content' => 'required']);

        $data = $request->all();
        $reply->send_reply($data);

        $id = $data['private_message_id'];
        return redirect('user_dashboard/message/' . $id);
    }

    public function destroy($id){

        // get private message
        $pm = PrivateMessage::findOrFail($id);

        // delete it
        $pm->delete_message();

        // redirect
        return redirect('user_dashboard/messages');

    }

}
