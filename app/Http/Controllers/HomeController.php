<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->limit(6)->get();
        return view('main/home/welcome', compact('posts'));
    }

    public function post($id){
        $post = Post::findOrFail($id);
        $comments = $post->comments()->orderBy('id', 'desc')->get();
        return view('main/home/post', compact('post', 'comments'));
    }

    public function older_posts(){
        $posts = Post::orderBy('id', 'desc')->skip(6)->take(100)->get();
        return view('main/home/older_posts', compact('posts'));
    }
}
