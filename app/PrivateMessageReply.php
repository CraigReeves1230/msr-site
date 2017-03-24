<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivateMessageReply extends Model
{
    protected $fillable = ['private_message_id', 'user_id', 'author_id', 'content'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function author(){
        return User::where('id', $this->author_id)->first();
    }

    public function private_message(){
        return $this->belongsTo('App\PrivateMessage');
    }
}
