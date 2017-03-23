@extends('layouts.front')
@section('title', 'Older Posts')
@section('page_title', 'Older Posts')
@section('page_heading_image', 'img/home-bg.jpg')
@section('content')

    @foreach($posts as $post)
        <div class="post-preview">
            <a href="{{route('read_article', ['id' => $post->id])}}"><h2>{{$post->title}}</h2>
                <h3>{{$post->subtitle}}</h3></a>
            <p class="post-meta">Posted by {{$post->user->name}}</p>
        </div>
        <hr>
    @endforeach

@endsection