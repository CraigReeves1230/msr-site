@extends('layouts.admin')
@section('content')

    <h1 class="text-center">Edit {{$ratings->user->name}}'s Ratings for {{$wrestler->name}}</h1>
    <hr>
    <div class="col-md-4">
        <img class="img-rounded" height="256" src="{{$wrestler->images[0]->path}}" alt="">
    </div>
    <div class="col-md-5">
        <form action="{{route('update_ratings', ['id' => $ratings->id])}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="__method" value="PUT">
            <div class="form-group">
                <input name="enabled" <?php
                        if($ratings->enabled == 1){
                            ?> checked='checked' <?php
                        }
                ?> type="checkbox"> <span style="font-size: 23px; margin-left: 4px;">Enabled</span>
            </div>
            <div class="form-group">
                <label for="striking"><h3>Striking</h3></label>
                <input name="striking" value="{{$ratings->striking}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="submission"><h3>Submission Execution</h3></label>
                <input name="submission" value="{{$ratings->submission}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="throws"><h3>Slams and Throws</h3></label>
                <input name="throws" value="{{$ratings->throws}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="movement"><h3>Transmission and Movement</h3></label>
                <input name="movement" value="{{$ratings->movement}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="sell_timing"><h3>Submission Execution</h3></label>
                <input name="sell_timing" value="{{$ratings->sell_timing}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="mat_and_chain"><h3>Mat and Chain Wrestling</h3></label>
                <input name="mat_and_chain" value="{{$ratings->mat_and_chain}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="setting_up"><h3>Setting Up</h3></label>
                <input name="setting_up" value="{{$ratings->setting_up}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="bumping"><h3>Bumping</h3></label>
                <input name="bumping" value="{{$ratings->bumping}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="technical"><h3>Technical Arsenal</h3></label>
                <input name="technical" value="{{$ratings->technical}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="high_fly"><h3>High Flying Offense</h3></label>
                <input name="high_fly" value="{{$ratings->high_fly}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="power"><h3>Power Moves</h3></label>
                <input name="power" value="{{$ratings->power}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="reaction"><h3>Reaction Time</h3></label>
                <input name="reaction" value="{{$ratings->reaction}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="durability"><h3>Durability and Resilience</h3></label>
                <input name="durability" value="{{$ratings->durability}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="conditioning"><h3>Physical Conditioning</h3></label>
                <input name="conditioning" value="{{$ratings->conditioning}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="basing"><h3>Basing</h3></label>
                <input name="basing" value="{{$ratings->basing}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="shine"><h3>Babyface Shine</h3></label>
                <input name="shine" value="{{$ratings->shine}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="heat"><h3>Heel Heat</h3></label>
                <input name="heat" value="{{$ratings->heat}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="comebacks"><h3>Babyface Comebacks</h3></label>
                <input name="comebacks" value="{{$ratings->comebacks}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="selling"><h3>Selling and Facials</h3></label>
                <input name="selling" value="{{$ratings->selling}}" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="ring_awareness"><h3>Ring Awareness</h3></label>
                <input name="ring_awareness" value="{{$ratings->ring_awareness}}" type="text" class="form-control">
            </div>

            <input type="submit" value="Update Ratings" class="btn btn-primary" name="submit" >
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