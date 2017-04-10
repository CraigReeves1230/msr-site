<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/31/2017
 * Time: 7:36 PM
 */

namespace App\Services\Gateways;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PMGateway
{

    public function enact($author, $recipient){

        // prevent other subscribers from receiving messages if user is banned
        if($author->status == 'banned'){
            if($recipient->admin == 0){
                Session::flash('gateway_pm', 'Your account has been banned. You are only allowed to message an administrator.');
                return true;
            }
        }

        // prevent message from being received if author is subscriber
        if($recipient->status == 'banned'){
            if($author->admin == 0){
                Session::flash('gateway_pm', 'This user has been banned. You will not be able to message this user.');
                return true;
            }
        }

        // admins cannot send to banned admins
        if($recipient->status == 'banned'){
            if($recipient->admin == 1){
                if($author->master == 0){
                    Session::flash('gateway_pm', 'Only the site owner can message a banned administrator.');
                    return true;
                }
            }
        }

        // banned admins cannot send messages to anyone but the owner
        if($author->status == 'banned'){
            if($author->admin == 1) {
                if($recipient->master == 0) {
                    Session::flash('gateway_pm', 'Your account has been banned. You are only allowed to message the site owner.');
                    return true;
                }
            }
        }

        // only the author and recipient can see a message
        if(Auth::user() != $author && Auth::user() != $recipient){
            Session::flash('gateway_pm', 'You are not allowed to view any private messages but your own.');
            return true;
        }

        // if the recipient has blocked the sender, don't allow sender to send message
		if(User::is_blocked(Auth::user(), $recipient)){
			Session::flash('gateway_pm', 'You have been blocked from sending messages to this user.');
			return true;
		}


    }


}