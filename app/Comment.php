<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = [
        'content', 'likes', 'user_id'
    ];

    public function commentable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function replies(){
        return $this->hasMany('App\CommentReply');
    }

    public function save_comment($commentable, $data){
        $this->content = $data['content'];
        $this->user_id = Auth::user()->id;
        $this->likes = 0;
        $commentable->comments()->save($this);
    }
}
