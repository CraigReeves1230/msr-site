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