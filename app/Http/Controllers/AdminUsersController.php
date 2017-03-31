<?php

namespace App\Http\Controllers;

use App\Services\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{

    protected $user_repository;

    public function __construct(UserRepository $user_repository){
        $this->middleware('admin');
        $this->user_repository = $user_repository;
    }

    public function index()
    {
        $users = $this->user_repository->all('paginate', 10);
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        $logged_in_user = Auth::user();
        return view('admin.users.create', compact('logged_in_user'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if($file = $request->file('image')){
            $image_name = $file->getClientOriginalName();
            $file->move('img', $image_name);
            $data['image'] = $image_name;
        } else {
            $data['image'] = 'genericface.jpg';
        }

        $this->user_repository->save($data);
        return redirect('admin/users');
    }

    public function edit($id)
    {
        $logged_in_user = Auth::user();
        $user = $this->user_repository->find($id);

        // Make it so that a banned user cannot be edited
        if ($logged_in_user->master == 0){
            if($user->status == "banned"){
                Session::flash('ban_edit_deny', 'Banned users cannot be edited.');
                return redirect('admin/users');
            }
        }

        // Make it so that an administrator cannot edit any other admin but his own
        if($logged_in_user->master == 0){
            if($user->admin == 1) {
                if($user->id != $logged_in_user->id){
                    //redirect
                    Session::flash('admin_denied', "You cannot edit another administrator's account.");
                    return redirect('admin/users');
                }
            }
        }
        return view('admin.users.edit', compact('user', 'logged_in_user'));
    }

    public function update(Request $request, $id)
    {
        // validate name no matter what
        $this->validate($request, ['name' => 'required|max:255']);

        // validate email only if it is changed
        if($request['email'] != $request['old_email']){
            $this->validate($request, ['email' => 'required|email|max:255|unique:users']);
        }

        // validate password only if it is changed
        if(!empty($request['password'])){

            $this->validate($request, ['password' => 'required|min:6|confirmed']);
        }

        // find user and store field data into data
        $data = $request->all();

        // upload image if new one was uploaded
        if($file = $request->file('image')){
            $image_name = $file->getClientOriginalName();
            $file->move('img', $image_name);
            $data['image'] = $image_name;
        }

        //update user and revert back to users
        $this->user_repository->update($id, $data);
        return redirect('admin/users');
    }

    public function ban_user($id){
        $user = $this->user_repository->find($id);
        $user->ban();
        return redirect('admin/users');
    }

    public function reinstate_user($id){
        $user = $this->user_repository->find($id);
        $user->reinstate();
        return redirect('admin/users');
    }

    public function search_users(Request $request){
        $search_query = $request['search_query'];
        $users = $this->user_repository->where('name', 'LIKE', "%$search_query%", 'get');
        if($search_query == "") {
            $users = $this->user_repository->all();
        }
        return view('admin.users.index', compact('users'));
    }

}
