<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use App\Services\Gateways\CommentsGateway;
use App\Services\RatingConverter;
use App\Services\Repositories\CommentReplyRepository;
use App\Services\Repositories\CommentsRepository;
use App\Services\Repositories\WrestlerRepository;
use App\Services\WrestlerRater;
use App\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWrestlersController extends Controller
{

    protected $wrestler_repository;
    protected $comments_repository;

    public function __construct(WrestlerRepository $wrestler_repository, CommentsRepository $comments_repository)
    {
        $this->middleware('auth');
        $this->wrestler_repository = $wrestler_repository;
        $this->comments_repository = $comments_repository;
    }

    public function show(Request $request, $id, WrestlerRater $wrestler_rater, RatingConverter $rating_converter)
    {

        $wrestler = $this->wrestler_repository->find($id);

        //calculate community scores

        //calculate execution
        $execution = round($wrestler_rater->calculate_execution($wrestler), 1) ;

        //calculate ability
        $ability = round($wrestler_rater->calculate_ability($wrestler), 1);

        //calculate psych
        $psychology = round($wrestler_rater->calculate_psychology($wrestler), 1);

        // get score
        $score = round($wrestler->community_rating, 1);

        // if these are not applicable, make "N/A"
        if ($execution == 0) $execution = 'N/A';
        if ($ability == 0) $ability = 'N/A';
        if ($psychology == 0) $psychology = 'N/A';
        if ($score == 0) $score = 'N/A';

        // get ratings user gave wrestler if user did give ratings to wrestler.
        $user = Auth::user();

        if ($user_ratings = $user->ratings()->where('wrestler_id', $wrestler->id)->first()) {

            //calculate user execution
            $user_execution = round($wrestler_rater->calculate_execution($user_ratings), 1);

            //calculate user ability
            $user_ability = round($wrestler_rater->calculate_ability($user_ratings), 1);

            //calculate user psych
            $user_psychology = round($wrestler_rater->calculate_psychology($user_ratings), 1);

            //get user score
            $user_score = round($user->ratings()->where('wrestler_id', $wrestler->id)->first()->overall_score, 1);

            // if these are not applicable, make "N/A"
            if ($user_execution == 0) $execution = 'N/A';
            if ($user_ability == 0) $ability = 'N/A';
            if ($user_psychology == 0) $psychology = 'N/A';
            if ($user_score == 0) $score = 'N/A';

        } else {
            $user_execution = "N/A";
            $user_ability = "N/A";
            $user_psychology = "N/A";
            $user_score = "N/A";
        }

        // get wrestler comments
        $comments = $wrestler->comments()->orderBy('id', 'desc')->get();

        // for json
        if($request->ajax()){

            $image_urls = [];
            $profile_urls = [];
            $created_ats = [];
            $update_urls = [];
            $replies = [];

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

            $json_payload = [
                "post" => $wrestler, "comments" => $comments, "image_urls" => $image_urls,
                "profile_urls" => $profile_urls, "created_ats" => $created_ats,
                "post_comment_url" => route('save_wrestler_comment', ['wrestler_id' => $wrestler->id]), "update_urls" => $update_urls, "replies" => $replies,
                "comment_reply_link" => route('save_wrestler_comment_reply'), "auth_user" => Auth::user(),
                "auth_guest" => Auth::guest(), "is_locked" => $wrestler->conversation_locked,
            ];

            return response()->json($json_payload);
        }

        return view('wrestler_profile.show', compact('user', 'wrestler', 'rating_converter', 'execution', 'user_score',
            'psychology', 'ability', 'score', 'user_execution', 'user_ability', 'user_psychology', 'comments'));
    }

    public function store_comment(Request $request, $id, CommentsGateway $gateway, CommentsRepository $comments_repository){

        // for ajax
        if($request->ajax()){

            $user = Auth::user();
            $wrestler = $this->wrestler_repository->find($id);

            // gateway for access
            if($gateway->enact($user, $wrestler)){
                return redirect()->back();
            }

            // save comment
            $comment = $comments_repository->save($wrestler, $request);

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
                    'id' => $reply->id,
                    'updateReplyURL' => route('update_wrestler_comment_reply', ['id' => $comment->id])
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
                "comment_reply_link" => route('save_post_comment_reply'),
                "user_id" => $comment->user->id,
                "commentUpdateURL" => route('update_post_comment', ['comment_id' => $comment->id])
            ];

            return response()->json($json_payload);
        }

        $user = Auth::user();
        $data = $request->all();
        $wrestler = $this->wrestler_repository->find($data['wrestler_id']);

        // gateway to access
        if($gateway->enact($user, null, $wrestler)){
            return redirect()->back();
        }

        $comments_repository->save($wrestler, $request);
        return redirect()->back();
    }

    public function update_comment(Request $request, $comment_id){

        // get the comment being edited and change the content
        $comment = $this->comments_repository->find($comment_id);

        if($comment->user == Auth::user()){
            $comment->content = $request->message_content;
            $comment->save();
        }

        // form json payload to send response
        $json_payload = [
            "profileURL" => route('user_profile', ['id' => $comment->user->id]),
            "imageURL" => $comment->user->images[0]->path,
            "username" => $comment->user->name,
            "createdAt" => $comment->created_at->diffForHumans(),
            "commentMessage" => $comment->content,
            "id" => $comment->id,
            "comment_reply_link" => route('save_post_comment_reply'),
            "user_id" => $comment->user->id,
            "commentUpdateURL" => route('update_post_comment', ['comment_id' => $comment->id])
        ];

        return response()->json($json_payload);
    }

    public function store_reply(Request $request, CommentsGateway $gateway, CommentReplyRepository $reply_repository){

        $user = Auth::user();
        $data = $request->all();
        $post = $this->comments_repository->find($request['comment_id'])->post;

        // gateway for access
        if ($gateway->enact($user, $post)) {
            return redirect()->back();
        }

        // save reply
        $reply = $reply_repository->save($data);

        // create json payload
        $json_payload = [
            "profileURL" => route('user_profile', ['id' => $reply->user->id]),
            "id" => $reply->id, "imageURL" => $reply->user->images[0]->path,
            "username" => $reply->user->name, "createdAt" => $reply->created_at->diffForHumans(),
            "replyMessage" => $reply->content, "comment_id" => $reply->comment->id,
            'update_reply_url' => route('update_post_comment_reply', ['reply_id' => $reply->id]),
            "user_id" => $reply->user->id,
            'updateReplyURL' => route('update_post_comment_reply', ['reply_id' => $reply->id])
        ];

        return response()->json($json_payload);
    }

    public function favorite($id){
        $user = Auth::user();
        $wrestler = $this->wrestler_repository->find($id);
        $user->favorite($wrestler);
        return redirect('wres_profile/' . $id);
    }

    public function unfollow($id){
        $user = Auth::user();
        $wrestler = $this->wrestler_repository->find($id);
        $user->unfollow($wrestler);
        return redirect('wres_profile/' . $id);
    }


}

