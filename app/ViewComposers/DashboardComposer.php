<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/28/2017
 * Time: 1:10 PM
 */

namespace App\ViewComposers;


use App\PrivateMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class DashboardComposer
{
    public function compose(View $view){
       $user = Auth::user();
       $private_messages = PrivateMessage::where([ ['user_id', $user->id], ['trash_id', '<>', $user->id ] ])
            ->orderBy('id', 'desc')->limit(2)->get();
       $alerts = $user->alerts()->orderBy('id', 'desc')->limit(5)->get();
       $view->with('user', $user);
       $view->with('alerts', $alerts);
       $view->with('private_messages', $private_messages);
    }
}