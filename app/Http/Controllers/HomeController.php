<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(4);
        return view('main/home/welcome', compact('posts'));
    }

    public function post($id, Request $request){

        if($request->ajax()){
            $post = Post::findOrFail($id);
            $comments = $post->comments()->orderBy('id', 'desc')->get();

            // these arrays and other data will carry additional data needed to show comments and replies
            $image_urls  = [];
            $profile_urls = [];
            $created_ats = [];
            $replies = [];
            $update_urls = [];
            foreach($comments as $comment){
                array_push($image_urls, $comment->user->images[0]->path);
                array_push($profile_urls, route('user_profile', ['id' => $comment->user->id]));
                array_push($created_ats, $comment->created_at->diffForHumans());
                array_push($update_urls, route('update_post_comment', ['comment_id' => $comment->id]));

                // this is for replies
                foreach($comment->replies as $reply){
                    array_push($replies, [
                        'profileURL' => route('user_profile', ['id' => $reply->user->id]),
                        'imageURL' => $reply->user->images[0]->path,
                        'username' => $reply->user->name,
                        'createdAt' => $reply->created_at->diffForHumans(),
                        'replyMessage' => $reply->content,
                        'comment_id' => $reply->comment->id,
                        'id' => $reply->id,
                        'user_id' => $reply->user->id,
                        'updateReplyURL' => route('update_post_comment_reply', ['reply_id' => $reply->id])
                    ]);
                }
            }
            $post_comment_url = route('save_post_comment', ['post_id' => $post->id]);


            // 'json_data'
            return response()->json([
                "post" => $post, "comments" => $comments, "image_urls" => $image_urls,
                "profile_urls" => $profile_urls, "created_ats" => $created_ats,
                "post_comment_url" => $post_comment_url, "update_urls" => $update_urls, "replies" => $replies,
                "comment_reply_link" => route('save_post_comment_reply'), "auth_user" => Auth::user(),
                "auth_guest" => Auth::guest(), "is_locked" => $post->locked
            ]);
        }

        $post = Post::findOrFail($id);
        $comments = $post->comments()->orderBy('id', 'desc')->get();
        return view('main/home/post', compact('post', 'comments'));
    }

}
