<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

}
