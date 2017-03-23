@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Edit User</h1>
    <hr>
    <div class="col-md-4">
        <img class="img-rounded" height="256" src="{{$user->images[0]->path}}">
    </div>
    <div class="col-md-5">
        <form action="{{route('users.update', ['id' => $user->id])}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}

            <div class="form-group">
                <label for="name"><h3>User Name</h3></label>
                <input value="{{$user->name}}" name="name" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label for="email"><h3>Email</h3></label>
                <input name="email" value="{{$user->email}}" type="email" class="form-control">
            </div>

            <!-- we need way to store old email -->
            <input type="hidden" name="old_email" value="{{$user->email}}">

            <div class="form-group">
                <label for="image"><h3>Image</h3></label>
                <input name="image" type="file">
            </div>

            <!-- only an owner can appoint admins -->
            @if($logged_in_user->master == 1)
                <div class="form-group">
                    <label for="email"><h3>Role</h3></label>
                    <select value="{{$user->admin}}" name="admin" class="form-control">
                        <option <?php if($user->admin == 0) {echo "selected='selected'";} ?> value="0">Subscriber</option>
                        <option <?php if($user->admin == 1) {echo "selected='selected'";} ?> value="1">Admin</option>
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label for="password"><h3>Password</h3></label>
                <input name="password" placeholder="Leave blank if you do not want password changed" type="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password-confirm"><h3>Confirm Password</h3></label>
                <input id="password-confirm" placeholder="Leave blank if you do not want password changed" type="password" class="form-control" name="password_confirmation">
            </div>

            <input value="Update User" type="submit" class="btn btn-primary" name="submit" >
        </form>

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