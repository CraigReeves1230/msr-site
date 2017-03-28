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

    public function send_message($author, $recipient, $content){

        $this->user_id = $recipient->id;
        $this->author_id = $author->id;
        $this->content = $content;
        $this->save();
        $recipient->new_messages = 1;
        $recipient->save();

        // send alert if message is from admin
        if($author->admin == 1){
            Alert::send_alert($recipient, "Admin Message", "info", $author->name . " has sent you a message.", route('pm_show', ['id' => $this->id]));
         }
    }

    public function delete_message(){

        // get the logged-in user
        $user = Auth::user();

        // only delete from database if it has been trashed or there have been no replies and the original author is
        // doing the deleting
        if($this->trash_id > 0 || (count($this->replies) < 1) && $this->author()->id == $user->id){
            // delete all replies as well as the message
            $this->replies()->delete();
            $this->delete();
        } else {
            // just simply trash the message but don't delete it from database
            $this->trash_id = $user->id;
            $this->save();
        }
    }
}
