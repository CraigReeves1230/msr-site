@extends('layouts.my_dashboard')
@section('page_title', 'Edit Your Profile')
@section('content')


    <div class="col-md-3">
        <img class="img-rounded" height="128" src="{{$user->images[0]->path}}" alt="">
    </div>


    <div class="col-md-6">
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

        <form action="{{route('dashboard_update_user')}}" method="post">
            {{method_field('PATCH')}}
            <div class="form-group">
                <label for="name"><h3>Name</h3></label>
                <input type="text" name="name" value="{{$user->name}}" class="form-control">
                {{csrf_field()}}
            </div>
            <div class="form-group">
                <label for="email"><h3>Email</h3></label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control">
            </div>

            <div class="form-group">
                <label for="image"><h3>Image</h3></label>
                <input name="image" type="file">
            </div>

            <div class="form-group">
                <label for="email"><h3>Write a Summary About Yourself</h3></label>
                <textarea name="summary" class="form-control">{{$user->summary}}</textarea>
                <script> CKEDITOR.replace( 'summary' ); </script>
            </div>

            <div class="form-group">
                <label for="password"><h3>Password</h3></label>
                <input name="password" placeholder="Leave blank if you do not want password changed" type="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password-confirm"><h3>Confirm Password</h3></label>
                <input id="password-confirm" placeholder="Leave blank if you do not want password changed" type="password" class="form-control" name="password_confirmation">
            </div>

            <input value="Update Account" type="submit" class="btn btn-primary" name="submit" >

            <!-- we need way to store old email -->
            <input type="hidden" name="old_email" value="{{$user->email}}">
        </form>

    </div>
@endsection