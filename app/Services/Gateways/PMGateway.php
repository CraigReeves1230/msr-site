<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/31/2017
 * Time: 7:36 PM
 */

namespace App\Services\Gateways;


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



    }


}