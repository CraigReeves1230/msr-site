@extends('layouts.front')
@section('title', 'Match Rating Tool')
@section('page_title', 'MATCH RATING TOOL')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <div class="row">
            <div class="container">
                <article>
                    It's what you came for, right? This tool is great for wrestling reviewers and critics who would like to assign star-ratings to matches objectively, fairly and with minimal bias. The lowest possible score is a 'DUD' rating and the highest is five stars (*****). An average match is about two stars (**). Simply rate each element of the match you watched as honestly as you can.
                </article><br>
            </div>



            <div class="container">

                <form action="{{route('rating_tool2')}}" method="post" class="form-horizontal">
                    {{csrf_field()}}
                    <h1 class="text-center">EXECUTION</h1><br>

                    <div class="form-group">
                        <label for="offense">Execution of Offense</label><br>
                        <select name="offense" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <label for="timing">Timing and Execution of Other Elements</label><br>
                        <select name="timing" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <label for="movement">Smoothness and Execution of Movement</label><br>
                        <select name="movement" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <h1 class="text-center">ATHLETICISM</h1><br>

                    <div class="form-group">
                        <label for="action">Action and Pace</label><br>
                        <select name="action" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <label for="excitement">Excitement of Spots</label><br>
                        <select name="excitement" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <h1 class="text-center">STORY AND PSYCHOLOGY</h1><br>

                    <div class="form-group">
                        <label for="time">Time Alotted</label><br>
                        <select name="time" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <label for="story">Story and Layout of Match</label><br>
                        <select name="story" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <label for="selling">Dramatic Performance and Selling</label><br>
                        <select name="selling" id="" class="form-control">
                            <option value="0.5">Worst Ever</option>
                            <option value="1.0">Bad</option>
                            <option value="2.0">Mediocre</option>
                            <option selected="selected" value="2.5">Decent</option>
                            <option value="3.0">Good</option>
                            <option value="3.5">Very Good</option>
                            <option value="4.0">Great</option>
                            <option value="4.5">Amazing</option>
                        </select>
                    </div><br>
                    <input type="submit" class="btn btn-primary" value="next" name="next">

                </form>
            </div>
        </div>



    <hr>

@endsection