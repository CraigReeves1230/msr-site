@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Edit Wrestler</h1>
    <hr>
    <div class="col-md-4">
        <img class="img-rounded" height="256" src="{{$wrestler->images[0]->path}}" alt="">
    </div>
    <div class="col-md-5">
    <form action="{{route('update_wrestler', ['id' => $wrestler->id])}}" method="post" enctype="multipart/form-data">
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
    </div>

    @endif
@endsection