<?php

namespace App\Http\Controllers;

use App\PrivateMessage;
use App\PrivateMessageReply;
use App\Services\Gateways\PMGateway;
use App\Services\Repositories\PMReplyRepository;
use App\Services\Repositories\PrivateMessageRepository;
use App\Services\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessagesController extends Controller
{
    protected $user_repository;
    protected $gateway;
    protected $pm_repository;
    protected $pm_reply_repository;

    public function __construct(UserRepository $user_repository, PMGateway $gateway,
                                PrivateMessageRepository $pm_repository,
                                PMReplyRepository $pm_reply_repository){
        $this->middleware('auth');
        $this->user_repository = $user_repository;
        $this->gateway = $gateway;
        $this->pm_repository = $pm_repository;
        $this->pm_reply_repository = $pm_reply_repository;
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
        $this->pm_repository->save($author, $recipient, $message);
        return redirect('user_dashboard/messages');
    }

    public function see_messages(){
        $user = Auth::user();

        // make it to where new messages is zero
        $user->new_messages = 0;
        $user->save();

        $private_messages = $this->pm_repository->where_optional_double([['user_id', $user->id], ['trash_id', '<>', $user->id]],
            [['author_id', $user->id], ['trash_id', '<>', $user->id]], 'paginate', 10);

        return view('private_messages/index', compact('user', 'private_messages'));
    }

    public function show($id){
        $user = Auth::user();
        $private_message = $this->pm_repository->find($id);
        $author = $private_message->author();
        $recipient = $private_message->user;

        // only allow either the author or recipient to go on
        if($this->gateway->enact($author, $recipient)){
            return redirect('/');
        }

        $private_message_replies = PrivateMessageReply::orderBy('id', 'asc')->where('private_message_id', $private_message->id)->get();
        return view('private_messages/show', compact('user', 'private_message', 'private_message_replies'));

    }

    public function send_reply(PrivateMessageReply $reply, Request $request){

        //handle validations
        $this->validate($request, ['content' => 'required']);

        // get the recipient
        $recipient = $this->pm_repository->find($request['private_message_id'])->author();

        if($this->gateway->enact(Auth::user(), $recipient)){
            return redirect()->back();
        }

        $data = $request->all();
        $this->pm_reply_repository->save($data);

        $id = $data['private_message_id'];
        return redirect('user_dashboard/message/' . $id);
    }

    public function destroy($id){

        // get private message
        $pm = $this->pm_repository->find($id);

        // delete it
        $this->pm_repository->delete($pm);

        // redirect
        return redirect('user_dashboard/messages');

    }

}
