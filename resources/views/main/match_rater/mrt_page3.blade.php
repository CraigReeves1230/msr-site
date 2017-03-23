@extends('layouts.front')
@section('title', 'Match Rating Tool')
@section('page_title', 'MATCH RATING TOOL')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <p>The current star-rating estimate you've given this match is:</p>

    <h1 class='text-center'>{{App\MatchRater::convertToStarRating($score)}}</h1>

    <form action="{{route('rating_tool4')}}" method="post">
        <br>
        <div class="form-group">
            {{csrf_field()}}
            <label for="choice">What is your first impression of this rating?</label><br>
            <input type="radio" checked="checked" name="choice" value="right"> This rating is just right<br>
            <input type="radio" name="choice" value="low"> This rating should be a little bit higher<br>
            <input type="radio" name="choice" value="high"> This rating is a little bit too high<br>
            <input type="hidden" name="score" value="<?php echo $score; ?>">
        </div><br>
        <input type="submit" value="Submit" name="final_submit" class="btn btn-primary">
        <br><br><br><br>
    </form>

@endsection