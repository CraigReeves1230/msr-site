@extends('layouts.my_profile')
@section('page_title', 'Private Message')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <section class="comment-list">

                    <!-- Message -->
                    <article class="row">
                        <div class="col-md-2 col-sm-2 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" height="64" src="{{$private_message->author()->images[0]->path}}" />
                                <figcaption class="text-center">{{$private_message->author()->name}}</figcaption>
                            </figure>
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <div class="panel panel-default arrow left">
                                <div class="panel-body">
                                    <header class="text-left">
                                        <div class="comment-user"><i class="fa fa-user"></i> {{$private_message->author()->name}}</div>
                                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{$private_message->created_at->diffForHumans()}}</time>
                                    </header>
                                    <div class="comment-post">
                                        <p>
                                            {{$private_message->content}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!--
                    <!-- Reply
                    <article class="row">
                        <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
                                <figcaption class="text-center">username</figcaption>
                            </figure>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <div class="panel panel-default arrow left">
                                <div class="panel-body">
                                    <header class="text-left">
                                        <div class="comment-user"><i class="fa fa-user"></i> That Guy</div>
                                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> Dec 16, 2014</time>
                                    </header>
                                    <div class="comment-post">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                        </p>
                                    </div>
                                    <p class="text-right"><a href="#" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> reply</a></p>
                                </div>
                            </div>
                        </div>
                    </article> -->




@endsection