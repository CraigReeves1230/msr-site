@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Create User</h1>
    <hr>
    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
            <label for="name"><h3>User Name</h3></label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="email"><h3>Email</h3></label>
            <input name="email" type="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="image"><h3>Image</h3></label>
            <input name="image" type="file">
        </div>

        @if($logged_in_user->master == 1)
            <div class="form-group">
                <label for="role"><h3>Role</h3></label>
                <select name="admin" class="form-control">
                    <option value="0">Subscriber</option>
                    <option value="1">Admin</option>
                </select>
            </div>
        @endif

        <div class="form-group">
            <label for="email"><h3>User Summary</h3></label>
            <textarea name="summary" class="form-control"></textarea>
            <script> CKEDITOR.replace( 'summary' ); </script>
        </div>

        <div class="form-group">
            <label for="password"><h3>Password</h3></label>
            <input name="password" type="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password-confirm"><h3>Confirm Password</h3></label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <input value="Create User" type="submit" class="btn btn-primary" name="submit" >
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


@endsection