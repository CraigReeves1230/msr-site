@extends('layouts.my_dashboard')
@section('page_title', 'My Ratings')
@section('content')


    @foreach($wrestlers as $wrestler)
    <div>
        <h2>{{$wrestler->name}}</h2>
        <img height="100" src="{{$wrestler->images[0]->path}}" alt="">
        <div style="margin: 20px;">
            <a class="btn btn-primary " href="{{route('wrestler_profile', ['id' => $wrestler->id])}}">View/Edit Details</a>
            <?php $rating = $wrestler->ratings()->where('user_id', $user->id)->first() ?>
            <h3>Your Rating: {{$rating->overall_score}}</h3>
        </div>
    </div>
    <hr>
    @endforeach

@endsection