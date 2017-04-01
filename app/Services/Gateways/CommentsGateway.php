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

    }
}