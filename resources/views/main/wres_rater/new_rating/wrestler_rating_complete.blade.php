@extends('layouts.front')
@section('title', 'Rate A Wrestler')
@section('page_title', 'RATE WRESTLER')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

        <div class="container">

            <h1>{{$wrestler->name}}'s ratings have been saved.</h1><br><br>
            <h3 class="text-center"><a href="{{route('home')}}">HOME</h3>
        </div>

    <hr>

@endsection