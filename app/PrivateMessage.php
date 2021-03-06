<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PrivateMessage extends Model
{
    protected $fillable = ['content', 'user_id', 'author_id', 'trash_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function author(){
        return User::findOrFail($this->author_id);
    }

    public function replies(){
        return $this->hasMany('App\PrivateMessageReply');
    }

}
