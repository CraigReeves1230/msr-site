@extends('layouts.my_profile')
@section('page_title', 'Received Messages')
@section('content')

    <div class="col-md-8">
    <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th></th>
            <th>From</th>
              <th>Received</th>
              <th class="text-center">Read</th>
            <th>Message Preview</th>
            <th class="text-center">Reply</th>
            <th class="text-center">Delete</th>
          </tr>
        </thead>
        <tbody>

        @foreach($private_messages as $pm)

          <tr>
            <td><img height='80' src="{{$pm->author()->images[0]->path}}" alt=""></td>
            <td>{{$pm->author()->name}}</td>
              <td>{{$pm->created_at->diffForHumans()}}</td>
              <td><a class="btn btn-info" href="{{route('pm_show', ['id' => $pm->id])}}">Read Message</a></td>
            <td>{{str_limit($pm->content, 180)}}</td>
            <td><button class="btn btn-primary">Reply</button></td>
              <td><button class="btn btn-danger">Delete</button></td>
          </tr>
        @endforeach

        </tbody>
      </table>
    </div>

@endsection