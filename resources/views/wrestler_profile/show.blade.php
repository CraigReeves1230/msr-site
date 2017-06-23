@extends('layouts.front')
@section('title', $wrestler->name)
@section('page_title', $wrestler->name)
@section('page_heading_image', 'img/home-bg.jpg')
@section('content')

<!-- nav bar -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-sm-3">

            @if($user->has_rated($wrestler))
                <a href="{{route('edit_rating1', $wrestler->id)}}" class="btn btn-danger btn-block btn-compose-email">Re-Rate This Wrestler</a>
            @else
                <a href="{{route('new_rating_go', $wrestler->id)}}" class="btn btn-danger btn-block btn-compose-email">Rate This Wrestler</a>
            @endif

            <ul class="nav nav-pills nav-stacked nav-email shadow mb-20">
                <li class="active">
                    @if(!$user->does_follow($wrestler))
                    <a href="{{route('wrestler_fav', $wrestler->id)}}">
                        <i class="fa fa-heart"></i> Favorite This Wrestler
                    </a>
                    @else
                        <a href="{{route('wrestler_unfollow', $wrestler->id)}}">
                            <i class="fa"></i> Unfollow This Wrestler
                        </a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-sm-9">


            <div class="panel panel-default">
                <div class="panel-heading resume-heading">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-xs-12 col-sm-4">
                                <figure>
                                    <img class="img-circle img-responsive" alt="" src="{{$wrestler->images[0]->path}}">
                                </figure>
                                <div class="row">
                                    <div class="col-xs-12 social-btns">

                                        <!-- twitter icon link -->
                                        @if(!empty($wrestler->twitter))
                                            <div class="col-xs-3  social-btn-holder">
                                                <a href="{{$wrestler->twitter}}" class="btn btn-social btn-block btn-twitter">
                                                    <i class="fa fa-twitter"></i> </a>
                                            </div>
                                        @endif

                                        <!-- instagram icon link -->
                                        @if(!empty($wrestler->instagram))
                                            <div class="col-xs-3 social-btn-holder">
                                                <a href="{{$wrestler->instagram}}" class="btn btn-social btn-block btn-instagram">
                                                    <i class="fa fa-instagram"></i> </a>
                                            </div>
                                        @endif

                                    </div>


                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <ul class="list-group">
                                    <li class="list-group-item"><h4>Name</h4></li>
                                    <li class="list-group-item">{{$wrestler->name}}</li>
                                    <li class="list-group-item"><h4>Gender</h4></li>
                                    @if($wrestler->gender == "male" || $wrestler->gender == null)
                                        <li class="list-group-item">Male</li>
                                    @else
                                        <li class="list-group-item">Female</li>
                                    @endif
                                    <li class="list-group-item"><h4>Community Rating</h4></li>
                                    @if($score == "N/A")
                                        <li class="list-group-item">{{$score}}</li>
                                    @else
                                        <li class="list-group-item">{{$rating_converter->convertToStarRating($score)}}</li>
                                    @endif
                                    <li class="list-group-item"><h4>Your Rating</h4></li>
                                    @if($user_score == "N/A")
                                        <li class="list-group-item">{{$user_score}}</li>
                                    @else
                                        <li class="list-group-item">{{$rating_converter->convertToStarRating($user_score)}}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bs-callout bs-callout-danger" style="padding: 20px;">
                    <h4>Biography</h4>
                    @if(!empty($wrestler->bio))
                        {!! $wrestler->bio !!}
                    @else
                        <div class="alert alert-danger" style="margin-top: 10px;">There is no biography written on this wrestler yet...</div>
                    @endif
                </div>

                @if($score != "N/A")
                    <div class="bs-callout bs-callout-danger">
                        <h4>Community Ratings</h4>
                        <ul class="list-group">
                            <div class="list-group-item inactive-link">

                                <div class="progress">
                                    <div data-placement="top" style="width: {{$execution * 20}}%;"
                                         aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($execution)}}">
                                        <span class="sr-only">80%</span>
                                        <span class="progress-type">Execution and Timing ({{$execution * 20}} out of 100) </span>
                                    </div>
                                </div>

                                <div class="progress">
                                    <div data-placement="top" style="width: {{$ability * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($ability)}}">
                                        <span class="sr-only">70%</span>
                                        <span class="progress-type">Ability and Athleticism ({{$ability * 20}} out of 100)</span>
                                    </div>
                                </div>

                                <div class="progress">
                                    <div data-placement="top" style="width: {{$psychology * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($psychology)}}">
                                        <span class="sr-only">70%</span>
                                        <span class="progress-type">Ring Psychology and Storytelling ({{$psychology * 20}} out of 100)</span>
                                    </div>
                                </div>

                                <div class="progress">
                                    <div data-placement="top" style="width: {{$score * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($score)}}">
                                        <span class="sr-only">70%</span>
                                        <span class="progress-type">Workrate Score ({{$rating_converter->workrate_iq($score)}})</span>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                @endif

                @if($user_score != "N/A")
                <div class="bs-callout bs-callout-danger">
                    <h4>Your Ratings</h4>
                    <ul class="list-group">
                        <div class="list-group-item inactive-link">

                            <div class="progress">
                                <div data-placement="top" style="width: {{$user_execution * 20}}%;"
                                     aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($user_execution)}}">
                                    <span class="sr-only">80%</span>
                                    <span class="progress-type">Execution and Timing ({{$user_execution * 20}} out of 100) </span>
                                </div>
                            </div>

                            <div class="progress">
                                <div data-placement="top" style="width: {{$user_ability * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($user_ability)}}">
                                    <span class="sr-only">70%</span>
                                    <span class="progress-type">Ability and Athleticism ({{$user_ability * 20}} out of 100)</span>
                                </div>
                            </div>

                            <div class="progress">
                                <div data-placement="top" style="width: {{$user_psychology * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($user_psychology)}}">
                                    <span class="sr-only">70%</span>
                                    <span class="progress-type">Ring Psychology and Storytelling ({{$user_psychology * 20}} out of 100)</span>
                                </div>
                            </div>

                            <div class="progress">
                                <div data-placement="top" style="width: {{$user_score * 20}}%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-{{$rating_converter->colorize_rating($user_score)}}">
                                    <span class="sr-only">70%</span>
                                    <span class="progress-type">Workrate Score ({{$rating_converter->workrate_iq($user_score)}})</span>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
</div>

<!-- comments section -->
<div class="container">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <div class="row">
        <div class="comments-container">

            @if(Session::has('comments_gateway'))
                <div class="alert alert-danger">{{session('comments_gateway')}}</div>
            @endif

            @if(count($wrestler->comments) > 0)
                <h1>Comments</h1>
            @endif

            @if(Auth::check())
            <!-- Comment form -->
                <form action="{{route('save_wrestler_comment')}}" method="post">
                    <div class="form-group">
                        <label for="content">Leave a Comment</label>
                        <textarea class="form-control" name="content" id="" rows="5"></textarea>
                        {{csrf_field()}}
                        <input type="hidden" name="wrestler_id" value="{{$wrestler->id}}">
                        <input style="margin-top: 8px;" value="Submit" type="submit" class="btn btn-default" name="leave_comment">
                    </div>
                </form>
            @endif

            @if(count($comments) > 0)
                <ul id="comments-list" class="comments-list">
                    <li>

                        <!-- Comment -->
                        @foreach($comments as $comment)
                            <div class="comment-main-level">
                                <div class="comment-avatar"><a href="{{route('user_profile', ['id' => $comment->user->id])}}"><img src="{{$comment->user->images[0]->path}}" alt=""></a></div>
                                <div class="comment-box">
                                    <div class="comment-head">
                                        <h6 class="comment-name"><a href="{{route('user_profile', ['id' => $comment->user->id])}}">{{$comment->user->name}}</a></h6>
                                        <span>posted {{$comment->created_at->diffForHumans()}}</span>
                                    </div>
                                    <div class="comment-content">
                                        {{$comment->content}}
                                    </div>
                                </div>
                            </div>
                            <!-- end of comment -->

                            <ul class="comments-list reply-list">

                                <!-- Comment replies -->
                                @foreach($comment->replies as $reply)
                                    <li>
                                        <div class="comment-avatar"><a href="{{route('user_profile', ['id' => $reply->user->id])}}"><img src="{{$reply->user->images[0]->path}}" alt=""></a></div>
                                        <div class="comment-box">
                                            <div class="comment-head">
                                                <h6 class="comment-name"><a href="{{route('user_profile', ['id' => $reply->user->id])}}">{{$reply->user->name}}</a></h6>
                                                <span>{{$reply->created_at->diffForHumans()}}</span>
                                            </div>
                                            <div class="comment-content">
                                                {{$reply->content}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            <!-- end comment response -->
                                <!-- comment reply form -->
                                @if(!$wrestler->conversation_locked)
                                    @if(Auth::check())
                                    <button class="btn btn-default btn-circle text-uppercase" onclick="document.querySelector('.reply-{{$comment->id}}').classList.toggle('hidden');" >Toggle Reply</button>
                                    <div class="reply-{{$comment->id}} hidden">
                                        <form action="{{route('save_wrestler_comment_reply')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group" style="margin-top: 10px;">
                                                <label for="content"><h4>Comment Reply</h4></label>
                                                <textarea class="form-control" name="content" rows="3"></textarea>
                                                <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                                <input type="submit" value="Reply" style="margin-top: 10px;" class="btn btn-primary" name="submit_reply">
                                            </div>
                                        </form>
                                    </div>
                                    @endif
                                @endif
                            <!-- end comment reply form -->
                            </ul>
                    </li>
                    @endforeach
                </ul>
        </div>
    </div>
</div>
@endif



@endsection
