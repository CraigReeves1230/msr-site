@extends('layouts.front')
@section('title', $user->name)
@section('page_title', $user->name)
@section('page_subtitle', '')
@section('page_heading_image', '/img/home-bg.jpg')
@section('content')

    <!-- nav bar -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    @if(Session::has('block_forbidden'))
        <div class="alert alert-danger">{{session('block_forbidden')}}</div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <a href="{{route('create_pm', ['id' => $user->id])}}" class="btn btn-primary btn-block btn-compose-email">Message User</a>

                @if(!App\User::is_blocked($user, Auth::user()))
                    <form method="post" action="{{route('block_user', ['id' => $user->id])}}">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-block btn-danger" value="Block User" name="block_user">
                    </form>
                @else
                    <form method="post" action="{{route('unblock_user', ['id' => $user->id])}}">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-block btn-success" value="Unblock User" name="block_user">
                    </form>
                @endif

            </div>

            <div class="col-sm-9">

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
            </div>
        </div>
    </div>

@endsection