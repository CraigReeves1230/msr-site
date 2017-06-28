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
            <div class="comments-container">

                @if(count($post->comments) > 0)
                    <h1>Comments</h1>
                @endif

                @if(Auth::check())
                <!-- Comment form -->
                <form class="comment-form" action="{{route('save_post_comment')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="content">Leave Comment</label>
                        <textarea class="form-control" name="content" id="" rows="5"></textarea>
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <input style="margin-top: 8px;" value="Submit" type="submit" class="btn btn-default" name="leave_comment">
                    </div>
                </form>
                @endif

                @if(count($comments) > 0)
                <div id="comments-list" class="comments-list">
                    <li>

                        <!-- Comment -->
                        @foreach($comments as $comment)
                            <div id="#comment-{{$comment->id}}" class="comment-main-level">
                                <div class="comment-avatar"><a href="{{route('user_profile', ['id' => $comment->user->id])}}"><img src="{{$comment->user->images[0]->path}}" alt=""></a></div>
                                <div class="comment-box">
                                    <div class="comment-head">
                                      <h6 class="comment-name"><a href="{{route('user_profile', ['id' => $comment->user->id])}}">{{$comment->user->name}}</a></h6>
                                        <span>posted {{$comment->created_at->diffForHumans()}}</span>
                                    </div>
                                    <div id="comment-content" class="comment-content">
                                        {{$comment->content}}
                                    </div>
                                </div>
                            </div>
                        <!-- end of comment -->

                        <ul class="comments-list reply-list">

                                @foreach($comment->replies as $reply)
                                <li>
                                    <div class="comment-avatar"><a href="{{route('user_profile', ['id' => $reply->user->id])}}"><img src="{{$reply->user->images[0]->path}}" alt=""></a></div>
                                        <div class="comment-box">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="{{route('user_profile', ['id' => $reply->user->id])}}">{{$reply->user->name}}</a></h6>
                                                <span>{{$reply->created_at->diffForHumans()}}</span>
                                            </div>
                                            <div id="reply-content" class="comment-content">
                                                {{$reply->content}}
                                            </div>
                                        </div>
                                </li>
                                @endforeach
                                <!-- end comment response -->
                                @if(!$post->locked)
                                    <!-- comment reply form -->
                                    @if(Auth::check())
                                    <button class="btn btn-default btn-circle text-uppercase"
                                            onclick="document.querySelector('.reply-{{$comment->id}}').classList.toggle('hidden');" >Toggle Reply</button>
                                    <div class="reply-{{$comment->id}} hidden">
                                        <form class="reply-form" data-comment-id="{{$comment->id}}" data-url="{{route('save_post_comment_reply')}}" id="reply-form-{{$comment->id}}" action="{{route('save_post_comment_reply')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group" style="margin-top: 10px;">
                                                <label for="content"><h4>Comment Reply</h4></label>
                                                <textarea id="reply-content" class="form-control" name="reply_content" rows="3"></textarea>
                                                <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                                <input type="submit" value="Submit Reply" style="margin-top: 10px;" class="btn btn-primary" name="submit_reply">
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                @endif
                                <!-- end comment reply form -->
                                </ul>
                            </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    @endif

@endsection


