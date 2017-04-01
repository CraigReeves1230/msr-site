@extends('layouts.my_dashboard')
@section('page_title', 'Private Messages')
@section('content')

    <div class="col-md-8">
    <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th></th>
            <th class="text-center">From</th>
              <th class="text-center">To</th>
              <th class="text-center">Received</th>
              <th class="text-center">View</th>
            <th class="text-center">Message Preview</th>
            <th class="text-center">Reply</th>
            <th class="text-center">Delete</th>
          </tr>
        </thead>
        <tbody>

        @foreach($private_messages as $pm)
          <tr>
              <td><img height='80' src="{{$pm->author()->images[0]->path}}"></td>

              @if($pm->author()->id == $user->id)
                  <td><a href="{{route('pm_show', ['id' => $pm->id])}}" style="color: white;" class="btn btn-success" style="color: #2b542c">Sent By You</a></td>
              @else
                  <td>{{$pm->author()->name}}</td>
              @endif

              @if($pm->user_id == $user->id)
                  <td><a href="{{route('pm_show', ['id' => $pm->id])}}" style="color: white;" class="btn btn-success" style="color: #2b542c">Sent To You</a></td>
              @else
                  <td>{{$pm->user->name}}</td>
              @endif

              <td>{{$pm->created_at->diffForHumans()}}</td>
              <td><a class="btn btn-info" href="{{route('pm_show', ['id' => $pm->id])}}">View Message</a></td>
              <td>{{str_limit($pm->content, 180)}}</td>
              <td>
                 <a href="{{route('pm_show', ['id' => $pm->id])}}" class="btn btn-primary">Reply</a>
              </td>
              <td>
                  <form action="{{route('delete_pm', ['id' => $pm->id])}}" method="post">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="submit" name="delete_message" value="Delete" class="btn btn-danger">
                  </form>
              </td>
          </tr>
        @endforeach

        </tbody>
      </table>
        {{$private_messages->links()}}
    </div>

@endsection