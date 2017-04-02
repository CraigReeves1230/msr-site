<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\CommentReply;
use App\Services\Gateways\CommentsGateway;
use App\Services\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostCommentsController extends Controller
{
    protected $gateway;
    protected $post_repository;

    public function __construct(CommentsGateway $gateway, PostRepository $post_repository){
        $this->middleware('auth');
        $this->gateway = $gateway;
        $this->post_repository = $post_repository;
    }

    public function store_comment(Comment $comment, Request $request){
        $user = Auth::user();
        $data = $request->all();
        $post = $this->post_repository->find($data['post_id']);

        // gateway for access
        if($this->gateway->enact($user, $post)){
            return redirect()->back();
        }

        // save comment
        $comment->save_comment($post, $data);
        return redirect()->back();
    }

    public function store_reply(CommentReply $reply, Request $request){
        $user = Auth::user();
        $data = $request->all();
        $post = Comment::find($request['comment_id'])->post;

        // gateway for access
        if($this->gateway->enact($user, $post)){
            return redirect()->back();
        }

        // save reply
        $reply->save_reply($data);
        return redirect()->back();
    }
}
