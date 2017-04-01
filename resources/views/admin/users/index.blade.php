@extends('layouts.admin')
@section('content')


    <h1 class="text-center">All Users</h1>
    <div class="container" style="margin-left: 0px;">
        <div>
            <div class="col-sm-4">
                <div id="imaginary_container" >
                    <form action="{{route('search_users')}}" method="post">
                        {{csrf_field()}}
                        <div class="input-group stylish-input-group">
                            <input type="text" name="search_query" class="form-control"  placeholder="Search" >
                            <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>

    <!-- flash messages -->
    @if(Session::has('already_banned'))
        <div class="alert alert-danger">{{session('already_banned')}}</div>
    @endif
    @if(Session::has('already_active'))
        <div class="alert alert-info">{{session('already_active')}}</div>
    @endif
    @if(Session::has('cannot_ban'))
        <div class="alert alert-danger">{{session('cannot_ban')}}</div>
    @endif
    @if(Session::has('cannot_reinstate'))
        <div class="alert alert-danger">{{session('cannot_reinstate')}}</div>
    @endif
    @if(Session::has('admin_denied'))
        <div class="alert alert-danger">{{session('admin_denied')}}</div>
    @endif
    @if(Session::has('ban_edit_deny'))
        <div class="alert alert-danger">{{session('ban_edit_deny')}}</div>
    @endif
    <!-- end flash messages -->

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Role</th>
            <th>Image</th>
            <th>View Posts</th>
            <th>View Ratings</th>
            <th>User Profile</th>
            <th>Edit</th>
            <th>Ban/Reinstate User</th>
        </tr>
        </thead>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->status == "banned")
                        <b style="color: red">Banned</b>
                    @elseif($user->status == "active")
                        <b style="color: green">Active</b>
                    @endif
                </td>
                <td>
                    @if($user->admin == 1 && $user->master == 0)
                        Administrator
                    @elseif($user->admin == 0)
                        Subscriber
                    @elseif($user->admin == 1 && $user->master == 1)
                        Owner
                    @endif
                </td>
                <td><img height="80" src="{{$user->images[0]->path}}"></td>
                <td><a href="{{route('see_posts', ['id' => $user->id])}}">View Posts</a></td>
                <td><a href="{{route('see_ratings', ['id' => $user->id])}}">View Ratings</a></td>
                <td><a href="{{route('user_profile', ['id' => $user->id])}}">User Profile</a></td>
                <td><a href="{{route('users.edit', ['id' => $user->id])}}">Edit</a></td>

                @if($user->status == "active")
                    <td><form method="post" action="{{route('ban_user', ['id' => $user->id])}}">
                            {{csrf_field()}} {{method_field("PATCH")}}
                        <input type="submit" class="btn btn-danger" name="ban" value="Ban User">
                    </form></td>
                @elseif($user->status == "banned")

                    <td><form method="post" action="{{route('reinstate_user', ['id' => $user->id])}}">
                            {{csrf_field()}} {{method_field("PATCH")}}
                            <input type="submit" class="btn btn-success" name="reinstate" value="Reinstate User">
                        </form></td>
                @endif
            </tr>
        @endforeach
    </table>

    {{$users->links()}}

@endsection