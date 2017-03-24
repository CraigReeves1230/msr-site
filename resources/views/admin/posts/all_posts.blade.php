@extends('layouts.admin')

@section('content')

    <h1 class="text-center">All Posts</h1>
    <div class="container" style="margin-left: 0px;">
        <div>
            <div class="col-sm-4">
                <div id="imaginary_container" >
                    <form action="{{route('all_posts_search')}}" method="post">
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
            <th>ID</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>Author</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Image</th>
            <th>Content</th>

        </tr>
        </thead>
        @foreach($posts as $post)
        <tr>
            <td>{{$post->id}}</td>
            <td><a href="{{route('read_article', ['id' => $post->id])}}">{{$post->title}}</a></td>
            <td>{{$post->subtitle}}</td>
            <td>{{$post->user->name}}</td>
            <td><a href="{{route('edit_post', ['id' => $post->id])}}">Edit</a></td>
            <td><a href="{{route('delete_post', ['id' => $post->id])}}">Delete</a></td>
            <td><img height="80" src="{{$post->images[0]->path}}"></td>
            <td>{{str_limit($post->content, 300)}}</td>
        </tr>
        @endforeach
    </table>



@endsection