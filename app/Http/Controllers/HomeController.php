<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(4);
        return view('main/home/welcome', compact('posts'));
    }

    public function post($id){
        $post = Post::findOrFail($id);
        $comments = $post->comments()->orderBy('id', 'desc')->get();
        return view('main/home/post', compact('post', 'comments'));
    }

}
