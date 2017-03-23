@extends('layouts.front')
@section('title', 'Match Rating Tool')
@section('page_title', 'MATCH RATING TOOL')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <div class="container">

        <form action="{{route('rating_tool3')}}" method="post" class="form-horizontal">
            <h1 class="text-center">CROWD INTERACTION</h1><br>

            <p>If you do not wish to factor the crowd interaction into the match rating, please select "DO NOT FACTOR".</p>

            <div class="form-group">
                {{csrf_field()}}
                <label for="crowd">Please provide your view of the crowd interaction during the match.</label><br>
                <select name="crowd" id="" class="form-control">
                    <option value="0.5">Worst Ever</option>
                    <option value="1.0">Bad</option>
                    <option value="2.0">Mediocre</option>
                    <option selected="selected" value="2.5">Decent</option>
                    <option value="3.0">Good</option>
                    <option value="3.5">Very Good</option>
                    <option value="4.0">Great</option>
                    <option value="4.5">Amazing</option>
                    <option value="99.0">DO NOT FACTOR</option>
                </select>
            </div>
            <input type="submit" value="Next" name="submit" class="btn btn-primary">
            <br><br><br><br><br>
        </form>
    </div>

@endsection