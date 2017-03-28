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
    <div class="col-md-4">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Community Rating</th>
                <th>Image</th>
                <th>Gender</th>
                <th>Bio</th>
                <th>Twitter</th>
                <th>Instagram</th>
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
                    <td>{{$wrestler->gender}}</td>
                    <td>{{str_limit($wrestler->bio, 80)}}</td>
                    <td>{{$wrestler->twitter}}</td>
                    <td>{{$wrestler->instagram}}</td>
                    <td><a href="{{route('all_ratings', ['id' => $wrestler->id])}}">User Ratings</a></td>
                    <td><a href="{{route('edit_wrestler', ['id' => $wrestler->id])}}">Edit</a></td>
                    <td>
                        <form method="post" action="{{route('delete_wrestler', ['id' => $wrestler->id])}}">
                            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$wrestlers->links()}}
    </div>





@endsection