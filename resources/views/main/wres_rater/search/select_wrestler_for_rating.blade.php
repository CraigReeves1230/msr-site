@extends('layouts.front')
@section('title', 'Rate A Wrestler')
@section('page_title', 'WRESTLER RATINGS')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <div class="row">
        <div class="container">
            <article>

            </article><br>
        </div>

        <div class="container">

        <form action="{{route('search_result')}}" method="post" class="form-horizontal">
            {{csrf_field()}}

            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Search Wrestler</h2>
                            <div id="custom-search-input">
                                <div class="input-group col-md-12">
                                    <input type="text" name="search_wrestler" class="form-control input-lg" placeholder="Search" />
                                    <span class="input-group-btn">
                    <button class="btn btn-info btn-lg" type="submit" name="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>

        </form>
    </div>
</div>
<hr>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <div class="container">

        @foreach($wrestlers as $wrestler)
        <div class="well">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" height="100" src="{{$wrestler->images[0]->path}}">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="{{route('wrestler_profile', ['id' => $wrestler->id])}}">{{$wrestler->name}}</a></h4>
                    <p>{!! $wrestler->bio !!}</p>
                    <ul class="list-inline list-unstyled">
                        <li></li>
                        <a href="{{route('wrestler_profile', $wrestler->id) }}">See Profile</a></span>
                        <li>|</li>
                        <span><i class="glyphicon glyphicon-heart"></i> {{count($wrestler->followers())}} followers</span>
                        <li>|</li>
                        <li>
                            Community Rating: <?php
                            if(!empty($wrestler->community_rating)) {
                                echo $rating_converter->convertToStarRating($wrestler->community_rating);
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
        {{$wrestlers->links()}}
    </div>

@endsection