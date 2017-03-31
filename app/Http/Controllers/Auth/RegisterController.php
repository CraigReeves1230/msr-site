<?php

namespace App\Http\Controllers\Auth;

use App\Services\Repositories\UserRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/';
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->middleware('guest');
        $this->user_repository = $user_repository;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        Session::flash('user_created', 'Your account has been created.');
        $user = new User;

        // set default values
        $data['admin'] = 0;
        $data['image'] = 'genericface.jpg';

        return $this->user_repository->save($data);
    }
}
