<?php

namespace App\Http\Controllers;

use App\Services\Repositories\UserRepository;
use App\Services\SiteMailer;
use App\Services\TokenMaker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{

    protected $token_maker;
    protected $site_mailer;
    protected $user_repository;

    public function __construct(TokenMaker $token_maker, SiteMailer $site_mailer, UserRepository $user_repository)
    {
        $this->token_maker = $token_maker;
        $this->site_mailer = $site_mailer;
        $this->user_repository = $user_repository;
    }

    public function store(Request $request){

        // get the email and user
        $email = $request->email;
        if($user = $this->user_repository->where('email', '=', $email, 'first')) {


            // create token and save an encrypted version to the user
            $keys = $this->token_maker->create();
            $user->reset_digest = $keys['key_encoded'];
            $user->reset_digest_time = Carbon::now()->addMinutes(10);
            $user->save();

            // send email
            $this->site_mailer->send_mail('password-resets@msr.com', 'MSR Admin', $user,
                'Password Reset', 'mail/password_reset', ['key' => $keys['key'], 'id' => $user->id, 'name' => $user->name]);

            Session::flash('reset_sent', 'Your password reset request has been sent to your email.');
            return redirect('/');
        } else {
            Session::flash('user_not_found', 'No account with this email exists.');
            return redirect('/');
        }

    }

    public function new_password($id, $key){

        //verify the key
        $user = $this->user_repository->find($id);
        $reset_digest = $user->reset_digest;

        if(Hash::check($key, $reset_digest)) {
            if (Carbon::now() < $user->reset_digest_time) {
                return view('auth/passwords/reset', compact('id', 'key', 'user'));
            }
        }

        Session::flash('reset_deny', 'Your password reset link has either expired or is incorrect. Please request another password reset link.');
        return redirect('/');
    }

    public function change_password($id, $key, Request $request){

        $user = $this->user_repository->where('email', '=', $request['email'], 'first');
        $reset_digest = $user->reset_digest;

        if(Hash::check($key, $reset_digest)){

            $data = $request->all();
            $this->user_repository->update($id, $data);
            Session::flash('reset_successful', 'Your password was successfully reset.');
            return redirect('/');

        } else {
            Session::flash('reset_deny',
                'Your password reset link has either expired or is incorrect. Please request another password reset link.');
            return redirect('/');
        }

    }

}
