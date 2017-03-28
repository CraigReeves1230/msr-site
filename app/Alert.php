<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['user_id', 'name', 'message', 'link', 'type'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public static function send_alert($user, $alert_name, $type, $message, $link){
        $alert = new Alert([
            'user_id' => $user->id,
            'name' => $alert_name,
            'message' => $message,
            'link' => $link,
            'type' => $type
        ]);
        $alert->save();
        $user->new_alerts = 1;
        $user->save();
    }

    public static function delete_alert($alert){
        $alert->delete();
    }
}


