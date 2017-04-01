<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\Repositories\PostRepository;
use App\Services\Repositories\UserRepository;
use App\Services\Repositories\WrestlerRatingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{

    protected $user_repository;
    protected $ratings_repository;
    protected $post_repository;

    public function __construct(UserRepository $user_repository,
                                WrestlerRatingRepository $ratings_repository,
                                    PostRepository $post_repository){
        $this->middleware('admin');
        $this->user_repository = $user_repository;
        $this->ratings_repository = $ratings_repository;
        $this->post_repository = $post_repository;
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

    public function see_ratings($id){
        $user = $this->user_repository->find($id);
        $ratings = $this->ratings_repository->where('user_id', '=', $user->id, 'paginate', 10);
        return view('admin/users/view_ratings', compact('ratings', 'user'));
    }

    public function see_posts($id){
        $user = $this->user_repository->find($id);
        $posts = $this->post_repository->where('user_id', '=', $user->id, 'paginate', 10);
        return view('admin/users/view_posts', compact('posts', 'user'));
    }

    public function user_posts_search($id, Request $request){
        $search_query = $request['search_query'];
        $user = $this->user_repository->find($id);
        if($search_query == ''){
            $posts = $this->post_repository->where('user_id', '=', $user->id, 'paginate', 10);
        } else {
            $posts = $this->post_repository->where_multiple([['user_id', $id], ['title', 'LIKE', "%$search_query%"]], 'paginate', 10);
        }
        return view('admin/users/view_posts', compact('posts', 'user'));
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
