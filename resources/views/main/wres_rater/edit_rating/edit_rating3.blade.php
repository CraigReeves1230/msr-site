@extends('layouts.front')
@section('title', 'The Most Unbiased Wrestling Bias Online')
@section('page_title', $wrestler->name)
@section('page_heading_image', '/img/home-bg.jpg')
@section('content')

    <div class="row">
        <div class="container">
            <article>

            </article><br>
        </div>

        <div class="container">

            <form action="{{route('edit_rating4', ['id' => $wrestler->id])}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                <h1 class="text-center">PSYCHOLOGY</h1><br>

                <div class="form-group">
                    <label for="shine">Babyface "Shine"</label>
                    <p>This rating evaluates a wrestler's charisma and ability to connect with the crowd
                        as a fan favorite, early in a wrestling match when he or she has the upper hand.</p>
                    <select name="shine" id="" class="form-control">
                        <option value="0.5">Worst Ever</option>
                        <option value="1.0">Bad</option>
                        <option value="2.0">Mediocre</option>
                        <option value="2.5" selected="selected">Decent</option>
                        <option value="3.0">Good</option>
                        <option value="3.5">Very Good</option>
                        <option value="4.0">Great</option>
                        <option value="4.5">Amazing</option>
                    </select>
                </div><br>

                <div class="form-group">
                    <label for="heat">"Heel" Heat</label>
                    <p>This rating evaluates a wrestler's performing ability playing a villain on offense. There
                        are cases in which a crowd might cheer for or show appreciation for a heel's performance, particularly if his or her performance is
                        strong (i.e., Curt Hennig). This rating, however, strictly evaluates the performance more than the crowd reaction
                        elicited.</p>
                    <select name="heat" id="" class="form-control">
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
                    <label for="comebacks">Comeback Fire</label>
                    <p>This rating evaluates a wrestler's dramatic performance as a babyface or fan favorite in connecting with the fans making his
                        or her big comeback, usually after being on the receiving end of an opponent's offense for a long period of time.</p>
                    <select name="comebacks" id="" class="form-control">
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
                    <label for="selling">Selling and Facials</label>
                    <p>This rating evaluates a wrestler's dramatic performance through the use of body language. This includes
                        realistically showing pain to make an opponent look strong. It also includes remembering to
                        make like a particular body part is ailing him or her if the opponent has attacked it throughout the match.
                        It also includes eliciting empathy from viewers and emotion through facial expressions, such as disappointment when unable to finish off
                        an opponent, or relief and exhaustion after winning a match. </p>
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

                <div class="form-group">
                    <label for="ring_awareness">Ring Awareness and Leadership</label>
                    <p>This rating evaluates the wrestler's ability to lead an opponent through a match. Oftentimes,
                        a young wrestler may rely upon a more experienced wrestler to guide them through a match.
                        This rating attempts to evaluate a wrestler's ability in leading or "calling" a match. Someone
                        strong in this area is very good at saving a match when a spot is blown or doesn't go as planned. They
                        are also very good at pulling a strong match out of an inexperienced opponent.</p>
                    <select name="ring_awareness" id="" class="form-control">
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

                <input type="submit" class="btn btn-primary" value="Submit Ratings" name="submit">

            </form>
        </div>
    </div>



    <hr>

@endsection