@extends('layouts.front')
@section('title', 'The Most Unbiased Wrestling Bias Online')
@section('page_title', $wrestler->name)
@section('page_heading_image', $wrestler->images[0]->path)
@section('page_subtitle', 'WRESTLER PROFILE')
@section('content')

<h1 style="margin-bottom: 50px;" class="text-center">Community Ratings</h1>
<h3 class="text-center">Community Score</h3>
@if($score == "N/A")
    <h4 class="text-center alert-info">Not enough users have given ratings to this wrestler yet for community ratings to be given.</h4>
    @else
    <h1 class="text-center" style="font-size: 50px; margin-bottom: 60px;">{{App\MatchRater::convertToStarRating($score)}}</h1>
@endif
<hr>
<h3>Execution</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$execution}}</h1>
<h3>Ability</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$ability}}</h1>
<h3>Psychology</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$psychology}}</h1>
<hr>
<h1 style="margin-bottom: 50px;" class="text-center">Your Ratings</h1>
<h3 class="text-center">Overall Score</h3>
<h1 class="text-center" style="font-size: 50px; margin-bottom: 60px;">{{App\MatchRater::convertToStarRating($user_score)}}</h1>
<hr>
<h3>Execution</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$user_execution}}</h1>
<h3>Ability</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$user_ability}}</h1>
<h3>Psychology</h3>
<h1 style="font-size: 50px; margin-bottom: 60px;">{{$user_psychology}}</h1>
<h4><a class="btn btn-default" href="{{route('edit_rating1', ['id' => $wrestler->id])}}">Redo Ratings</a></h4>

@endsection
