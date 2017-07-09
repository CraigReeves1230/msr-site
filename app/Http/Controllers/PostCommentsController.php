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

    public function store_comment(Request $request, $post_id){

        // for ajax
        if($request->ajax()){

            $user = Auth::user();
            $post = $this->post_repository->find($post_id);

            // gateway for access
            if($this->gateway->enact($user, $post)){
                return redirect()->back();
            }

            // save comment
            $comment = $this->comments_repository->save($post, $request);

            // this is for replies to be available in json object
            $replies_array = [];
            foreach($comment->replies as $reply){
                array_push($replies, [
                    'profileURL' => route('user_profile', ['id' => $reply->user->id]),
                    'imageURL' => $reply->user->images[0]->path,
                    'username' => $reply->user->name,
                    'createdAt' => $reply->created_at->diffForHumans(),
                    'replyMessage' => $reply->content,
                    'comment_id' => $reply->comment->id,
                    'id' => $reply->id
                ]);
            }

            $json_payload = [
                "profileURL" => route('user_profile', ['id' => $comment->user->id]),
                "imageURL" => $comment->user->images[0]->path,
                "username" => $comment->user->name,
                "createdAt" => $comment->created_at->diffForHumans(),
                "commentMessage" => $comment->content,
                "id" => $comment->id,
                "replies" => $replies_array,
                "comment_reply_link" => route('save_post_comment_reply')
            ];

            return response()->json($json_payload);
        }

        // for view
        $user = Auth::user();
        $post = $this->post_repository->find($post_id);

        // gateway for access
        if($this->gateway->enact($user, $post)){
            return redirect()->back();
        }

        // save comment
        $comment = $this->comments_repository->save($post, $request);

        return redirect()->back();
    }

    public function store_reply(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $data = $request->all();
            $post = $this->comments_repository->find($request['comment_id'])->post;

            // gateway for access
            if($this->gateway->enact($user, $post)){
                return redirect()->back();
            }

            // save reply
            $reply = $this->comment_reply_repository->save($data);

            // create json payload
            $json_payload = [
                "profileURL" => route('user_profile', ['id' => $reply->user->id]),
                "id" => $reply->id, "imageURL" => $reply->user->images[0]->path,
                "username" => $reply->user->name, "createdAt" => $reply->created_at->diffForHumans(),
                "replyMessage" => $reply->content, "comment_id" => $reply->comment->id
            ];

            return response()->json($json_payload);
        }

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
