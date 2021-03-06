@extends('layouts.front')
@section('title', 'Private Message')
@section('page_title', 'Private Message')
@section('page_subtitle', '')
@section('page_heading_image', '/img/home-bg.jpg')

@section('content')

    <h1 class="text-center">Send Message</h1>
    <hr>
    <div class="col-md-4">
        <a href="{{route('user_profile', ['id' => $recipient->id])}}">
            <img class="img-rounded" height="128" src="{{$recipient->images[0]->path}}"></a>
        <a href="{{route('user_profile', ['id' => $recipient->id])}}"><h4>{{$recipient->name}}</h4></a>
    </div>
    <div class="col-md-5">
        <form action="{{route('store_pm', ['id' => $recipient->id])}}" method="post">
            {{csrf_field()}}
            <textarea name="content" class="form-control" rows="5"></textarea>
            <input value="Submit Message" type="submit" style="margin-top: 10px;" class="btn btn-primary" name="submit" >
        </form>

        @if(Session::has('gateway_pm'))
            <div class="alert alert-danger" style="margin-top: 10px;">{{session('gateway_pm')}}</div>
        @endif

        <!-- Display errors -->
        @if(count($errors) > 0)
            <div class="alert alert-danger" style="margin-top: 10px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


@endsection