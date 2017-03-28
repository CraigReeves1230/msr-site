@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Edit Post</h1>
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
    <form action="{{route('update_post', ['id' => $post->id])}}" method="post" enctype="multipart/form-data">
        {{method_field('PATCH')}}
        <div class="form-group">
            <label for="title"><h3>Post Title</h3></label>
            <input value="{{$post->title}}" name="title" type="text" class="form-control">
            {{csrf_field()}}
        </div>
        <div class="form-group">
            <label for="subtitle"><h3>Post Subtitle</h3></label>
            <input value="{{$post->subtitle}}" name="subtitle" type="text" class="form-control">
        </div>
        <div class="form-group">
            <img height="100" src="{{$post->images[0]->path}}" alt=""><br>
            <label for="image"><h3>Image</h3></label>
            <input name="image" type="file">
        </div>
        <div class="form-group">
            <label for="content"><h3>Post Content</h3></label>
            <textarea class="form-control" name="content">{{$post->content}}</textarea>
            <!-- This script changes the textarea to a full featured word processor (www.ckeditor.com) -->
            <script> CKEDITOR.replace( 'content' ); </script>
        </div>
        <input type="submit" value="Update Post" class="btn btn-primary" name="Update Post" >
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