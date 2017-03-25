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

    public function send_reply($data){
        $data = $request->all();
        $id = $request['private_message_id'];
        $user = Auth::user();
        $private_message = PrivateMessage::findOrFail($id);
        $content = $request['content'];
        $author = Auth::user();
        $recipient_id = $private_message->author()->id;
        $reply = new PrivateMessageReply(['user_id' => $recipient_id,
            'author_id' => $author->id,
            'private_message_id' => $id,
            'content' => $content]);
        $reply->save();
        return redirect('user_dashboard/message/' . $id);
    }
}
