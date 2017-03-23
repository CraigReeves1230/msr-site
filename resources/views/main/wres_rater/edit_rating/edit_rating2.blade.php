@extends('layouts.front')
@section('title', 'The Most Unbiased Wrestling Bias Online')
@section('page_title', $wrestler->name)
@section('page_heading_image', $wrestler->images[0]->path)
@section('page_subtitle', 'EDIT RATINGS')
@section('content')

<div class="container">

    <form action="{{route('edit_rating3', ['id' => $wrestler->id])}}" method="post" class="form-horizontal">
        {{csrf_field()}}
        <h1 class="text-center">ABILITY</h1><br>

        <div class="form-group">
            <label for="technical">Technical Offense</label>
            <p>This rating attempts to evaluate the maximum impressiveness and difficulty level of the individual's arsenal of technical
                wrestling-based offense. Remember, this is measuring <u>maximum</u> ability,
                <em>not</em> what is commonly seen in a wrestler's matches, as most wrestlers are not going to be able to demonstrate the full
                extent of their capabilities in every match, especially if they are not headlining the show. Here, you will attempt to offer
                an educated guess as to what the wrestler's maximum capabilities are in this area based on what you <em>have</em> seen.</p>
            <select name="technical" id="" class="form-control">
                <option value="2.0">Worst Ever</option>
                <option value="2.0">Bad</option>
                <option value="2.0">Mediocre</option>
                <option selected="selected" value="2.5">Decent</option>
                <option value="3.0">Good</option>
                <option value="3.5">Very Good</option>
                <option value="4.0">Great</option>
                <option value="4.5">Amazing</option>
            </select>
        </div><br>

        <div class="form-group">
            <label for="high_fly">Aerial Offense</label>
            <p>This rating attempts to evaluate the maximum impressiveness and level of difficulty of a wrestler's arsenal of aerial offense.
                This is strictly measuring flying and diving moves only. Keep in mind that this is measuring <u>maximum</u> ability, <em>not</em>
                what is normally seen in the wrestler's matches, as it is unrealistic to expect a wrestler to demonstrate
                his or her maximum capabilities in every match, especially if he or she isn't headlining the show. Here, you will attempt to offer
                an educated guess as to what maximum capabilities may exist for the wrestler in this area based on what you <em>have</em> seen.</p>
            <select name="high_fly" id="" class="form-control">
                <option value="2.0">Worst Ever</option>
                <option value="2.0">Bad</option>
                <option value="2.0">Mediocre</option>
                <option selected="selected" value="2.5">Decent</option>
                <option value="3.0">Good</option>
                <option value="3.5">Very Good</option>
                <option value="4.0">Great</option>
                <option value="4.5">Amazing</option>
            </select>
        </div><br>

        <div class="form-group">
            <label for="power">Lifting and Power Moves</label>
            <p>This rating attempts to evaluate the impressiveness and level of difficulty of a wrestler's arsenal of lifting moves,
                throws, slams and power-based offense.
                Remember, this is measuring maximum ability, <em>not</em>
                what is commonly seen in the wrestler's matches as booking constraints and the opponents the wrestler faces might prevent
                him or her from demonstrating maximum capability in this area. Here, you will attempt to offer
                an educated guess as to what you believe is possible given all other conditions being ideal.</p>
            <select name="power" id="" class="form-control">
                <option value="2.0">Worst Ever</option>
                <option value="2.0">Bad</option>
                <option value="2.0">Mediocre</option>
                <option selected="selected" value="2.5">Decent</option>
                <option value="3.0">Good</option>
                <option value="3.5">Very Good</option>
                <option value="4.0">Great</option>
                <option value="4.5">Amazing</option>
            </select>
        </div><br>

        <div class="form-group">
            <label for="reaction">Reaction Time</label>
            <p>This rating evaluates a wrestler's ability to react or "keep up" with another wrestler. If
                the wrestler can keep up with an extremely fast-moving wrestler, even if he or she isn't fast-moving him or herself,
                a high rating would be given. However, if a wrestler's opponent has to "slow down" for the wrestler
                to keep up, a lower score would be given.</p>
            <select name="reaction" id="" class="form-control">
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
            <label for="durability">Durability and Resilience</label>
            <p>This rating evaluates a wrestler's physical resilience and durability. If a wrestler is
                able to take big bumps safely or is able to work a much more physical style than others, a
                high rating would be given. If a wrestler is highly injury-prone or simply unwilling or unable
                to be on the receiving end of physicality, this might limit what
                his or her opponent can do in the ring, negatively impacting the match.</p>
            <select name="durability" id="" class="form-control">
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
            <label for="conditioning">Cardio Conditioning</label>
            <p>This rating evaluates a wrestler's physical endurance. This is important not only
                because it affects the activity level of a match, particularly one that goes the distance, but it also
                impacts the safety level of a match as a worker with great physical conditioning won't
                be too tired physically to execute or take big moves late in a match.</p>
            <select name="conditioning" id="" class="form-control">
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
            <label for="basing">Base From Aerial Offense</label>
            <p>This rating evaluates a wrestler's ability to safely break the fall of a flying opponent.
                The most common example of this is a wrestler outside the ring taking a flying
                move from an opponent. If a wrestler is able to break his or her
                opponent's fall safely, it increases the amount of and/or difficulty of flying moves the other wrestler
                can perform in a match.</p>
            <select name="basing" id="" class="form-control">
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

@endsection
