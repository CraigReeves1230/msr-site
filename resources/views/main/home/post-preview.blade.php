@extends('layouts.post_preview')
@section('title', $preview->title)

@section('page_title', $preview->title)
@section('page_subtitle', $preview->subtitle)
@section('page_heading_image', $preview->images[0]->path)

@section('content')

    <p style="color: #9d9d9d; font-style: italic; text-align: center">THIS IS A PREVIEW...</p>

    {!! $preview->content !!}

    <hr>

@endsection
