<?php

namespace App\Http\Controllers;

use app\Includes\Search;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Image;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function create(){
        return view('admin/posts/create_post');
    }

    public function store(Request $request){

        // validations
        $this->validate($request, ['title' => 'required',
            'subtitle' => 'required', 'content' => 'required']);

        $post = new Post;
        $post->save_post($request);

        return redirect('admin/posts/all');
    }

    public function update(Request $request, $id){

        // validations
        $this->validate($request, ['title' => 'required',
            'subtitle' => 'required', 'content' => 'required']);

        $post = Post::findOrFail($id);
        $post->update_post($request);

        return redirect('admin/posts/all');
    }

    public function edit($id){
        $post = Post::findOrFail($id);
        return view('admin/posts/edit_post', compact('post'));
    }

    public function delete($id){
        $post = Post::findOrFail($id);
        $post->delete_post();
        return redirect('admin/posts/all');
    }

    public function allposts(){
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin/posts/all_posts', compact('posts'));
    }

    public function search_posts(Request $request){
        $search_query = $request['search_query'];
        $posts = Post::where('title', 'LIKE', "%$search_query%")->paginate(10);
        if($search_query == "") {
            $posts = Post::orderBy('id', 'desc')->get();
        }
        return view('admin.posts.all_posts', compact('posts'));
    }

}
