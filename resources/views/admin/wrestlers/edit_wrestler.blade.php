@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Edit Wrestler</h1>
    <hr>
    <div class="col-md-4">
        <img class="img-rounded" height="256" src="{{$wrestler->images[0]->path}}" alt="">
    </div>
    <div class="col-md-5">

    <form action="{{route('update_wrestler', ['id' => $wrestler->id])}}" method="post" enctype="multipart/form-data">
        {{method_field('PATCH')}}
        <input type="hidden" name="__method" value="PUT">
        <div class="form-group">
            <label for="name"><h3>Wrestler Name</h3></label>
            <input name="name" value="{{$wrestler->name}}" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="image"><h3>Image</h3></label>
            <input name="image" type="file">
        </div>
        <div class="form-group">
            <label for="altname1"><h3>Altnernate Name 1</h3></label>
            <input name="altname1"
                   @if(!empty($wrestler->alt_names[1]))
                        value="{{$wrestler->alt_names[1]->name}}"
                   @endif
                   type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="altname2"><h3>Altnernate Name 2</h3></label>
            <input name="altname2"
                   @if(!empty($wrestler->alt_names[2]))
                        value="{{$wrestler->alt_names[2]->name}}"
                   @endif
                   type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="altname3"><h3>Altnernate Name 3</h3></label>
            <input name="altname3"
                   @if(!empty($wrestler->alt_names[3]))
                        value="{{$wrestler->alt_names[3]->name}}"
                   @endif
                   type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="gender"><h3>Gender</h3></label>
            <select name="gender" class="form-control">
                @if($wrestler->gender == "male" || $wrestler->gender == null)
                    <option selected="selected" value="male">Male</option>
                    <option value="female">Female</option>
                @else
                    <option value="male">Male</option>
                    <option selected="selected" value="female">Female</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="twitter"><h3>Twitter Link</h3></label>
            <input value="{{$wrestler->twitter}}" name="twitter" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="instagram"><h3>Instagram Link</h3></label>
            <input value="{{$wrestler->instagram}}" name="instagram" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="bio"><h3>Bio</h3></label>
            <textarea class="form-control" name="bio">{{$wrestler->bio}}</textarea>
            <!-- This script changes the textarea to a full featured word processor (www.ckeditor.com) -->
            <script> CKEDITOR.replace( 'bio' ); </script>
        </div>
        <input type="submit" value="Update Wrestler" class="btn btn-primary" name="submit" >
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
    </div>

    @endif
@endsection