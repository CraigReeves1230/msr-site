<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    protected $fillable = [
        'content', 'likes', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    public function save_reply($data){
        $this->content = $data['content'];
        $this->user_id = Auth::user()->id;
        $this->likes = 0;
        $comment = Comment::findOrFail($data['comment_id']);
        $comment->replies()->save($this);
    }
}
