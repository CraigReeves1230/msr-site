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

@if(Session::has('comments_gateway'))
    <div class="alert alert-danger">{{session('comments_gateway')}}</div>
@endif

<!-- comments section -->
<div class="container">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <div class="row">
        <div class="comments-container" data-url="{{route('wrestler_profile', ['wrestler_id' => $wrestler->id])}}" id="root"></div>
    </div>
</div>

<script src="/js/comments-combined.js"></script>

@endsection
