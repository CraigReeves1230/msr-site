@extends('layouts.my_dashboard')
@section('page_title', 'My Favorites')
@section('content')


    @foreach($wrestlers as $wrestler)
        <div>
            <h2>{{$wrestler->name}}</h2>
            <img height="100" src="{{$wrestler->images[0]->path}}" alt="">
            <div style="margin: 20px;">
                <a class="btn btn-primary " href="{{route('wrestler_profile', ['id' => $wrestler->id])}}">View/Edit Details</a>
                <?php $rating = $wrestler->ratings()->where('user_id', $user->id)->first() ?>
                @if(!empty($rating))
                    <h3>Your Rating: {{$rating->overall_score}}</h3>
                @else
                    <h3>Your Rating: N/A</h3>
                @endif
                <a href="{{route('remove_favorite', ['id' => $wrestler->id])}}">Remove From Favorites</a>
            </div>
        </div>
        <hr>

    @endforeach
    {{$wrestlers->links()}}

@endsection