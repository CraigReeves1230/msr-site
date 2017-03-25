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
        $message = $request['content'];
        $author = Auth::user();
        $recipient = User::findOrFail($id);
        $pm->send_message($author, $recipient, $message);
        return redirect('user_dashboard/messages');
    }

    public function see_messages(){
        $user = Auth::user();

        // get all private messages that were sent to user or by user
        $private_messages = PrivateMessage::where([  ['user_id', $user->id], ['trash_id', '<>', $user->id]   ])
            ->orWhere([ ['author_id', $user->id], ['trash_id', '<>', $user->id] ])
            ->orderBy('id', 'desc')->get();

        return view('private_messages/index', compact('user', 'private_messages'));
    }

    public function show($id){
        $user = Auth::user();
        $private_message = PrivateMessage::findOrFail($id);
        $private_message_replies = PrivateMessageReply::orderBy('id', 'asc')->where('private_message_id', $private_message->id)->get();
        return view('private_messages/show', compact('user', 'private_message', 'private_message_replies'));
    }

    public function send_reply(Request $request){
        $data = $request->all();
        $id = $request['private_message_id'];
        $user = Auth::user();
        $private_message = PrivateMessage::findOrFail($id);
        $content = $request['content'];
        $author = Auth::user();
        $recipient_id = $private_message->author()->id;
        $reply = new PrivateMessageReply(['user_id' => $recipient_id,
                                            'author_id' => $author->id,
                                            'private_message_id' => $id,
                                            'content' => $content]);
        $reply->save();
        return redirect('user_dashboard/message/' . $id);
    }

    public function delete($id){

        // get the user
        $user = Auth::user();

        // get pm from database
        $pm = PrivateMessage::findOrFail($id);

        // only delete from database if it has been trashed or there have been no replies
        if($pm->trash_id > 0 || count($pm->replies) < 1){
            // delete all replies as well as the message
            $pm->replies()->delete();
            $pm->delete();
        } else {
            // just simply trash the message but don't delete it from database
            $pm->trash_id = $user->id;
            $pm->save();
        }

        // redirect
        return redirect('user_dashboard/messages');

    }

}
