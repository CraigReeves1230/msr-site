<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\CommentReply;
use App\Services\Gateways\CommentsGateway;
use App\Services\Repositories\CommentReplyRepository;
use App\Services\Repositories\CommentsRepository;
use App\Services\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostCommentsController extends Controller
{
    protected $gateway;
    protected $post_repository;
    protected $comments_repository;
    protected $comment_reply_repository;

    public function __construct(CommentsGateway $gateway, PostRepository $post_repository,
                                CommentsRepository $comments_repository,
                                CommentReplyRepository $comment_reply_repository){
        $this->middleware('auth');
        $this->gateway = $gateway;
        $this->post_repository = $post_repository;
        $this->comments_repository = $comments_repository;
        $this->comment_reply_repository = $comment_reply_repository;
    }

    public function store_comment(Request $request){
        $user = Auth::user();
        $data = $request->all();
        $post = $this->post_repository->find($data['post_id']);

        // gateway for access
        if($this->gateway->enact($user, $post)){
            return redirect()->back();
        }

        // save comment
        $this->comments_repository->save($post, $data);
        return redirect()->back();
    }

    public function store_reply(Request $request){

        $user = Auth::user();
        $data = $request->all();
        $post = $this->comments_repository->find($request['comment_id'])->post;

        // gateway for access
        if($this->gateway->enact($user, $post)){
            return redirect()->back();
        }

        // save reply
        $this->comment_reply_repository->save($data);
        return redirect()->back();

    }
}
