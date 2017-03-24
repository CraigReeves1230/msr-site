<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\CommentReply;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store_comment(Comment $comment, Request $request){
        $data = $request->all();
        $post = Post::findOrFail($data['post_id']);
        $comment->save_comment($post, $data);
        return redirect()->back();
    }

    public function store_reply(CommentReply $reply, Request $request){
        $data = $request->all();
        $reply->save_reply($data);
        return redirect()->back();
    }
}
