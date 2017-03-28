@extends('layouts.front')
@section('title', 'The Most Unbiased Wrestling Bias Online')
@section('page_title', 'MATCH STAR RATER')
@section('page_subtitle', 'THE MOST UNBIASED WRESTLING BIAS ONLINE')
@section('page_heading_image', 'img/home-bg.jpg')
@section('content')

    @if(Session::has('user_created'))
        <div class="alert alert-success">{{session('user_created')}}</div>
    @endif

    @foreach($posts as $post)
        <div class="post-preview">
            <a href="{{route('read_article', ['id' => $post->id])}}"><h2>{{$post->title}}</h2>
            <h3>{{$post->subtitle}}</h3></a>
            <p class="post-meta">Posted by <a href="{{route('user_profile', [$post->user->id])}}">{{$post->user->name}}</a> on {{$post->created_at->toFormattedDateString()}}</p>
        </div>
        <hr>
    @endforeach

    <!-- Pager -->
    <ul class="pager">
        <li class="next">
            <a href="<?php echo route('older_posts') ?>">Older Posts &rarr;</a>
        </li>
    </ul>

@endsection