<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/3/2017
 * Time: 8:40 PM
 */

namespace App\Services;


use App\Services\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;



class SiteMailer
{

    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function send_mail($sender_email, $sender_name, $recipient, $subject, $view, $data = [])
    {

        Mail::send($view, $data, function($message) use($sender_email, $sender_name, $recipient, $subject){

            $message->from($sender_email, $sender_name);
            $message->to($recipient->email)->subject($subject);

        });

    }

}