@extends('layouts.my_dashboard')
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


                    <!-- Reply -->
                    @foreach($private_message_replies as $reply)
                    <article class="row">
                        <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
                            <figure class="thumbnail">
                                <img class="img-responsive" height="64" src="{{$reply->author()->images[0]->path}}" />
                                <figcaption class="text-center">{{$reply->author()->name}}</figcaption>
                            </figure>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <div class="panel panel-default arrow left">
                                <div class="panel-body">
                                    <header class="text-left">
                                        <div class="comment-user"><i class="fa fa-user"></i> {{$reply->author()->name}}</div>
                                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{$reply->created_at->diffForHumans()}}</time>
                                    </header>
                                    <div class="comment-post">
                                        <p>
                                            {{$reply->content}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach

                <!-- Display errors -->
                    @if(count($errors) > 0)
                        <div class="alert alert-danger" style="margin-top: 10px;">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{route('send_pm_reply')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="content"><h4>Send Reply</h4></label>
                            <textarea rows="5" class="form-control" name="content"></textarea>
                            <input type="hidden" value="{{$private_message->id}}" name="private_message_id">
                            <input type="submit" value="Reply" style="margin-top: 10px;" class="btn btn-primary" name="submit_reply">
                        </div>
                    </form>






@endsection