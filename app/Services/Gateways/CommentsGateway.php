<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/31/2017
 * Time: 9:02 PM
 */

namespace App\Services\Gateways;


use Illuminate\Support\Facades\Session;

class CommentsGateway
{
    public function enact($user, $post = null, $comment = null){

        // don't allow banned users
        if($user->status == 'banned'){
            Session::flash('comments_gateway', 'Your account has been banned. You are not allowed to leave comments or replies.');
            return true;
        }

        // don't allow comments or replies on a locked thread
        if($post != null) {
            if ($post->locked) {
                Session::flash('comments_gateway', 'This thread has been locked. No one will be able to leave comments or replies.');
                return true;
            }
        }

    }
}