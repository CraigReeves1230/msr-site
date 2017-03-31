@extends('layouts.admin')

@section('content')

    <h1 class="text-center">All Ratings For {{$wrestler->name}}</h1>

    <hr>
    <div>
        <table class="table table-bordered table-hover BORDER=1 HEIGHT="40%" ">
            <thead>
            <tr>
                <th>USER</th>
                <th>STK</th>
                <th>SUB</th>
                <th>THROW</th>
                <th>MOV</th>
                <th>SELL-TIMING</th>
                <th>MAT</th>
                <th>SETUP</th>
                <th>BUMP</th>
                <th>TECHNICAL</th>
                <th>HIGH-FLY</th>
                <th>POW</th>
                <th>REAC-TIME</th>
                <th>DUR</th>
                <th>COND</th>
                <th>BAS</th>
                <th>SHINE</th>
                <th>HEAT</th>
                <th>COMEBACKS</th>
                <th>SELL</th>
                <th>AWARE</th>
                <th><b>OVERALL</b></th>
                <th>Edit</th>
                <th>Delete</th>

            </tr>
            </thead>
            @foreach($ratings as $rating)
                <tr>
                    <td>{{$rating->user->name}}</td>
                    <td>{{$rating->striking}}</td>
                    <td>{{$rating->submission}}</td>
                    <td>{{$rating->throws}}</td>
                    <td>{{$rating->movement}}</td>
                    <td>{{$rating->sell_timing}}</td>
                    <td>{{$rating->mat_and_chain}}</td>
                    <td>{{$rating->setting_up}}</td>
                    <td>{{$rating->bumping}}</td>
                    <td>{{$rating->technical}}</td>
                    <td>{{$rating->high_fly}}</td>
                    <td>{{$rating->power}}</td>
                    <td>{{$rating->reaction}}</td>
                    <td>{{$rating->durability}}</td>
                    <td>{{$rating->conditioning}}</td>
                    <td>{{$rating->basing}}</td>
                    <td>{{$rating->shine}}</td>
                    <td>{{$rating->heat}}</td>
                    <td>{{$rating->comebacks}}</td>
                    <td>{{$rating->selling}}</td>
                    <td>{{$rating->ring_awareness}}</td>
                    <td>{{$rating->overall_score}}</td>
                    <td><a href="{{route('edit_ratings', ['id' => $rating->id])}}">Edit</a></td>
                    <td><a href="{{route('delete_ratings', ['id' => $rating->id])}}">Delete</a></td>
                </tr>
            @endforeach
        </table>
                {{$ratings->links()}}
    </div>



@endsection