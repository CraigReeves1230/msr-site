<?php

namespace App\Http\Controllers;

use App\PrivateMessage;
use App\PrivateMessageReply;
use App\Services\Gateways\PMGateway;
use App\Services\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessagesController extends Controller
{
    protected $user_repository;
    protected $gateway;

    public function __construct(UserRepository $user_repository, PMGateway $gateway){
        $this->middleware('auth');
        $this->user_repository = $user_repository;
        $this->gateway = $gateway;
    }

    public function create($id){
        $recipient = $this->user_repository->find($id);
        return view('private_messages/create', compact('recipient'));
    }

    public function store(PrivateMessage $pm, $id, Request $request){

        // validations
        $this->validate($request, ['content' => 'required']);
        $author = Auth::user();
        $recipient = $this->user_repository->find($id);

        // gateway for access
        if($this->gateway->enact($author, $recipient)){
            return redirect("message/{$recipient->id}/create");
        }

        $message = $request['content'];
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

        // get the recipient
        $recipient = PrivateMessage::find($request['private_message_id'])->author();

        if($this->gateway->enact(Auth::user(), $recipient)){
            return redirect()->back();
        }

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
