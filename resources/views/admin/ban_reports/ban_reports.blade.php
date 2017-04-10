@extends('layouts.admin')

@section('content')

    <h1 class="text-center">Ban Report</h1>
    @if(Session::has('cannot_reinstate'))
        <div class="alert alert-danger">{{session('cannot_reinstate')}}</div>
    @endif
    @if(Session::has('admin_denied'))
        <div class="alert alert-danger">{{session('admin_denied')}}</div>
    @endif
    @if(Session::has('already_active'))
        <div class="alert alert-info">{{session('already_active')}}</div>
    @endif
    <hr>
    <table class="table table-bordered table-hover">
        <thead>
            <th class="text-center">User</th>
            <th class="text-center">Banned By</th>
            <th class="text-center">Reinstate User</th>
        </thead>
        @foreach($ban_list as $ban)
        <tbody>
            <td class="text-center">{{$ban['user']->name}}</td>
            <td class="text-center">{{$ban['admin']->name}}</td>
            <td class="text-center">
                <form method="post" action="{{route('reinstate_user', ['id' => $ban['user']->id])}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <input type="submit" class="btn btn-success" value="Reinstate User" name="submit">
                </form>
            </td>
        </tbody>
        @endforeach
    </table>


@endsection