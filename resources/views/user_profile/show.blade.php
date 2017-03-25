@extends('layouts.front')
@section('title', $user->name)
@section('page_title', $user->name)
@section('page_subtitle', '')
@section('page_heading_image', '/img/home-bg.jpg')
@section('content')

    <!-- nav bar -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <a href="{{route('create_pm', ['id' => $user->id])}}" class="btn btn-primary btn-block btn-compose-email">Message User</a>
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
                                    <div class="row">
                                        <div class="col-xs-12 social-btns">
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-google">
                                                    <i class="fa fa-google"></i> </a>
                                            </div>
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-facebook">
                                                    <i class="fa fa-facebook"></i> </a>
                                            </div>
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-twitter">
                                                    <i class="fa fa-twitter"></i> </a>
                                            </div>
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-linkedin">
                                                    <i class="fa fa-linkedin"></i> </a>
                                            </div>
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-github">
                                                    <i class="fa fa-github"></i> </a>
                                            </div>
                                            <div class="col-xs-3 col-md-1 col-lg-1 social-btn-holder">
                                                <a href="#" class="btn btn-social btn-block btn-stackoverflow">
                                                    <i class="fa fa-stack-overflow"></i> </a>
                                            </div>
                                        </div>


                                    </div>
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
                        <h4>Summary</h4>
                        <p>
                            Lorem ipsum dolor sit amet, ea vel prima adhuc, scripta liberavisse ea quo, te vel vidit mollis complectitur. Quis verear mel ne. Munere vituperata vis cu,
                            te pri duis timeam scaevola, nam postea diceret ne. Cum ex quod aliquip mediocritatem, mei habemus persecuti mediocritatem ei.
                        </p>
                        <p>
                            Odio recteque expetenda eum ea, cu atqui maiestatis cum. Te eum nibh laoreet, case nostrud nusquam an vis.
                            Clita debitis apeirian et sit, integre iudicabit elaboraret duo ex. Nihil causae adipisci id eos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection