@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Create Post</h1>
    <hr>
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
    <form action="{{route('preview_post')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title"><h3>Post Title</h3></label>
            <input name="title" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="subtitle"><h3>Post Subtitle</h3></label>
            <input name="subtitle" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="image"><h3>Image</h3></label>
            <input name="image" type="file">
        </div>
        <div class="form-group">
            <label for="content"><h3>Post Content</h3></label>
            <textarea class="form-control" name="content"></textarea>
            <!-- This script changes the textarea to a full featured word processor (www.ckeditor.com) -->
            <script> CKEDITOR.replace( 'content' ); </script>
        </div>
        <input type="submit" value="Preview/Publish" class="btn btn-primary" name="submit" >
    </form>

    @endsection