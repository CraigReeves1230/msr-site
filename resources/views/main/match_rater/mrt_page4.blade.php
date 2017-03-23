@extends('layouts.front')
@section('title', 'Match Rating Tool')
@section('page_title', 'MATCH RATING TOOL')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <p class="text-center">
        <b>The star-rating for this match:</b>
    </p>

    <h1 class='text-center'>{{$star_rating}}</h1>

@endsection