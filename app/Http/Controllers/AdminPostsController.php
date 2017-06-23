<?php

namespace App\Http\Controllers;

use app\Includes\Search;
use App\Services\Repositories\PostPreviewRepository;
use App\Services\Repositories\PostRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Image;
use Illuminate\Support\Facades\Auth;

class AdminPostsController extends Controller
{

    protected $post_repository;

    public function __construct(PostRepository $post_repository)
    {
        $this->middleware('admin');
        $this->post_repository = $post_repository;

    }

    public function create(){
        return view('admin/posts/create_post');
    }

    public function preview(Request $request, PostPreviewRepository $preview_repository){

        // refresh previews database
        $user = Auth::user();
        $user->post_previews()->delete();

        $this->validate($request, ['title' => 'required',
            'subtitle' => 'required', 'content' => 'required',
            'image' => 'required|image']);

        $preview = $preview_repository->save($request);

        return view('main.home.post-preview', compact('preview'));
    }

    public function store(PostPreviewRepository $preview_repository){

        // get the user and post
        $user = Auth::user();
        $preview = $user->post_previews[0];

        // create new post
        $post = new Post([
            'title' => $preview->title,
            'subtitle' => $preview->subtitle,
            'user_id' => $preview->user_id,
            'content' => $preview->content,
        ]);

        // save post
        $this->post_repository->simple_save($post);

        // save post image
        $post->images()->save($preview->images[0]);

        // discard preview
        $preview_repository->delete($preview);

        return redirect('admin/posts/all');
    }

    public function update(Request $request, $id){

        // validations
        $this->validate($request, ['title' => 'required',
            'subtitle' => 'required', 'content' => 'required', 'image' => 'image']);

        $this->post_repository->update($id, $request);
        return redirect('admin/posts/all');
    }

    public function edit($id){
        $post = $this->post_repository->find($id);
        return view('admin/posts/edit_post', compact('post'));
    }

    public function delete($id){
        $post = $this->post_repository->find($id);
        $this->post_repository->delete($post);
        return redirect()->back();
    }

    public function allposts(){
        $posts = $post = $this->post_repository->all('paginate', 10);
        return view('admin/posts/all_posts', compact('posts'));
    }

    public function search_posts(Request $request){
        $search_query = $request['search_query'];
        $posts = $this->post_repository->where('title', 'LIKE', "%$search_query%", 'paginate', 10);
        if($search_query == "") {
            $posts = $this->post_repository->all('paginate', 10);
        }
        return view('admin.posts.all_posts', compact('posts'));
    }

}
