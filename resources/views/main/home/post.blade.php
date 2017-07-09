@extends('layouts.front')
@section('title', $post->title)

@section('page_title', $post->title)
@section('page_subtitle', $post->subtitle)
@section('page_heading_image', $post->images[0]->path)

@section('content')

    {!! $post->content !!}

    <hr>

    @if(Session::has('comments_gateway'))
        <div class="alert alert-danger">{{session('comments_gateway')}}</div>
    @endif

    <!-- comments section -->
    <div class="container">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <div class="row">
                <div class="comments-container" data-url="{{route('read_article', ['id' => $post->id])}}" id="root"></div>
        </div>
    </div>


    <script src="/js/comments-combined.js"></script>

@endsection



