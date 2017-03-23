@extends('layouts.admin')

@section('content')

    <h1 class="text-center">View Wrestlers</h1>
    <div class="container" style="margin-left: 0px;">
        <div>
            <div class="col-sm-4">
                <div id="imaginary_container" >
                    <form action="{{route('all_wrestlers_search')}}" method="post">
                        {{csrf_field()}}
                        <div class="input-group stylish-input-group">
                            <input type="text" name="search_query" class="form-control"  placeholder="Search" >
                            <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </form>
                    </span>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Community Rating</th>
            <th>Image</th>
            <th>User Ratings</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        @foreach($wrestlers as $wrestler)
            <tr>
                <td>{{$wrestler->name}}</td>
                <td>{{$wrestler->community_rating}}</td>
                <td><img height="80" src="{{$wrestler->images[0]->path}}"></td>
                <td><a href="{{route('all_ratings', ['id' => $wrestler->id])}}">User Ratings</a></td>
                <td><a href="{{route('edit_wrestler', ['id' => $wrestler->id])}}">Edit</a></td>
                <td><a href="{{route('delete_wrestler', ['id' => $wrestler->id])}}">Delete</a></td>
            </tr>
        @endforeach
    </table>



@endsection