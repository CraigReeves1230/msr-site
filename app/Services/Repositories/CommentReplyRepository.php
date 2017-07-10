<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/2/2017
 * Time: 7:04 PM
 */

namespace App\Services\Repositories;


use App\CommentReply;
use Illuminate\Support\Facades\Auth;

class CommentReplyRepository
{

    protected $comments_repository;

    public function __construct(CommentsRepository $comments_repository)
    {
        $this->comments_repository = $comments_repository;
    }

    public function save($data, $reply = null){

        if($reply == null){
            $reply = new CommentReply;
        }

        $reply->content = $data['reply_content'];
        $reply->user_id = Auth::user()->id;
        $reply->likes = 0;
        //$comment = Comment::findOrFail($data['comment_id']);
        $comment = $this->comments_repository->find($data['comment_id']);
        $comment->replies()->save($reply);

        return $reply;
    }

    public function find($id){
        return CommentReply::find($id);
    }

}