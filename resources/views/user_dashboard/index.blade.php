@extends('layouts.my_dashboard')
@section('page_title', 'My Profile')

@section('content')

    <!-- resume -->
    <div class="panel panel-default">
        <div class="panel-heading resume-heading">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-xs-12 col-sm-4">
                        <figure>
                            <img class="img-circle img-responsive" alt="" src="{{$user->images[0]->path}}">
                        </figure>
                    </div>
                    <div class="col-xs-12 col-sm-8">

                        <ul class="list-group">
                            <li class="list-group-item">{{$user->name}}</li>
                            @if($user->admin == 1 && $user->master == 0)
                                <li class="list-group-item">Administrator</li>
                            @elseif($user->admin == 0)
                                <li class="list-group-item">Subscriber</li>
                            @elseif($user->admin == 1 && $user->master == 1)
                                <li class="list-group-item">Site Owner</li>
                            @endif
                            <li class="list-group-item"><i class="fa fa-envelope"></i> {{$user->email}}</li>
                        </ul>

                    </div>
                    <!-- recent comments -->
                @if(count($recent_comments) > 0)
                    <!-- Container, Row, and Column used for illustration purposes -->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Begin fluid width widget -->
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <span class="glyphicon glyphicon-list-alt"></span>  Recent Comments
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="media-list">
                                                @foreach($recent_comments as $comment)
                                                    <li class="media">
                                                        <div class="media-body">
                                                            <h4 class="media-heading">
                                                                @if($comment->commentable_type == 'App\Post')
                                                                    <a href="{{route('read_article', $comment->commentable_id)}}" class="text-info">
                                                                        Re: {{str_limit($comment->commentable->title, 20)}}
                                                                        <span style="color: #9d9d9d; font-style: italic; font-size: small">
                                                                                ({{$comment->created_at->diffForHumans()}})</span>
                                                                    </a>
                                                                @elseif($comment->commentable_type == 'App\Wrestler')
                                                                    <a href="{{route('wrestler_profile', $comment->commentable_id)}}" class="text-info">
                                                                        Re: {{$comment->commentable->name}}
                                                                        <span style="color: #9d9d9d; font-style: italic; font-size: small">
                                                                                ({{$comment->created_at->diffForHumans()}})</span>
                                                                    </a>
                                                                @endif

                                                            </h4>
                                                            <p class="margin-top-10 margin-bottom-20">
                                                                {{str_limit($comment->content, 93)}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <a href="#" class="btn btn-default btn-block">More Comments »</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        <div class="bs-callout bs-callout-danger" style="margin: 20px;">
            @if(!empty($user->summary))
                <h4>Summary</h4>
                {!! $user->summary !!}
            @endif
        </div>
    </div>

@endsection