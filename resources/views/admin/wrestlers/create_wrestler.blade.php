@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Create Wrestler</h1>
    <hr>
    <form action="{{route('store_wrestler')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name"><h3>Wrestler Name</h3></label>
            <input name="name" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="image"><h3>Image</h3></label>
            <input name="image" type="file">
        </div>
        <div class="form-group">
            <label for="altname1"><h3>Altnernate Name 1</h3></label>
            <input name="altname1" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="altname2"><h3>Altnernate Name 2</h3></label>
            <input name="altname2" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="altname3"><h3>Altnernate Name 3</h3></label>
            <input name="altname3" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="gender"><h3>Gender</h3></label>
            <select name="gender" class="form-control">
                <option selected="selected" value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="twitter"><h3>Twitter Link</h3></label>
            <input name="twitter" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="instagram"><h3>Instagram Link</h3></label>
            <input name="instagram" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="bio"><h3>Bio</h3></label>
            <textarea class="form-control" name="bio"></textarea>
            <!-- This script changes the textarea to a full featured word processor (www.ckeditor.com) -->
            <script> CKEDITOR.replace( 'bio' ); </script>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" >
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