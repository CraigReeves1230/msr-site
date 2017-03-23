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



    <hr>

@endsection