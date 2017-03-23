@extends('layouts.front')
@section('title', 'Rate A Wrestler')
@section('page_title', 'RATE WRESTLER')
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
                    <p>Please search for the name of the wrestler you will be evaluating.</p>
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
    <div class="container">

        <hgroup class="mb20">
            <h1>Search Results</h1>
            <h2 class="lead"><strong class="text-danger">{{count($wrestlers)}}</strong>
                results were found for the search for <strong class="text-danger">{{$search_query}}</strong></h2>
            <?php
                if(count($wrestlers) < 1){
                    echo "Unfortunately, this wrestler is not yet in our database.
                    If you would like this wrestler added, please contact us.";
                }
            ?>
        </hgroup>

        <section class="col-xs-12 col-sm-6 col-md-12">

            @foreach($wrestlers as $wrestler)
            <article class="search-result row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <a href="{{route('new_rating_go', $wrestler->id)}}" title="{{$wrestler->name}}"
                       class="thumbnail"><img src="{{$wrestler->get_image()}}" alt="{{$wrestler->name}}" /></a>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <ul class="meta-search">
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 excerpet">

                        <h3><a href="{{route('new_rating_go', $wrestler->id)}}" title="" style="color: #0f74a8;">{{$wrestler->name}}</a></h3>

                    <p>Community Rating: <?php
                        if(!empty($wrestler->community_rating)) {
                            echo App\MatchRater::convertToStarRating($wrestler->community_rating);
                        } else {
                            echo "N/A";
                        }
                    ?></p>
                    <p>
                        Workrate IQ: <?php
                if(!empty($wrestler->community_rating)) {
                    $w_iq = round(($wrestler->community_rating * 10 * 2 + 60), 2);
                    echo $w_iq;
                } else {
                    echo "N/A";
                } ?>
                    </p>

                </div>
                <span class="clearfix borda"></span>
            </article>
            @endforeach

        </section>
    </div>



    <hr>

@endsection