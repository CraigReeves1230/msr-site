@extends('layouts.front')
@section('title', 'Rate A Wrestler')
@section('page_title', 'RATE WRESTLER')
@section('page_subtitle', '')
@section('page_heading_image', 'img/home-bg.jpg')

@section('content')

    <div class="row">
        <div class="container">
            <article>

            </article><br>
        </div>



        <div class="container">

            <form action="{{route('new_rating2')}}" method="post" class="form-horizontal">
                {{csrf_field()}}
                <h1 class="text-center">EXECUTION</h1><br>

                <div class="form-group">
                    <label for="striking">Striking</label>
                    <p>This rating evaluates the wrestler's execution in working strike-based offense. If a wrestler
                    is able to make his or her strikes look believable without seriously hurting their opponents,
                    a high rating will be given here. Strikes include any and all moves that involve a part of one
                    wrestler's body striking an opponent. This would obviously include all punches and kicks but also
                    splashes, clotheslines, leg drops and elbow drops.</p>
                    <select name="striking" id="" class="form-control">
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
                    <label for="throws">Slams and Throws</label>
                    <p>This rating evaluates the wrestler's execution
                    strictly with throws and slams. This rating isn't evaluating how <em>impressive</em> the wrestler's
                    offense is in this area, but just how proficiently he or she
                    executes these moves.</p>
                    <select name="throws" id="" class="form-control">
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
                    <label for="submission">Submission Offense Execution</label>
                    <p>This rating evaluates the wrestler's execution
                        in applying working submission holds. </p>
                    <select name="submission" id="" class="form-control">
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
                    <label for="movement">Movement and Transitioning</label>
                    <p>This rating evaluates how smoothly a wrestler moves in the ring. This includes
                     but is not limited to running the ropes, rolls and going in and out of the ring. It also
                    evaluates how smoothly a wrestler transitions from one hold to another as well as from one spot
                        to another.</p>
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

                <div class="form-group">
                    <label for="mat_and_chain">Mat and Chain Wrestling</label>
                    <p>This rating evaluates a wrestler's ability to engage in mat and chain wrestling sequences.</p>
                    <select name="mat_and_chain" id="" class="form-control">
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
                    <label for="sell_timing">Timing of Selling Opponent Offense</label>
                    <p>This rating evaluates a wrestler's timing and execution in receiving an opponent's offense. An example of this is correctly timing a working punch from an opponent,
                    knowing when to snap one's head back to make the punch look real.  Another example is being able to properly time flipping and taking a bump when receiving an armdrag or hip-toss.</p>
                    <select name="sell_timing" id="" class="form-control">
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
                    <label for="setting_up">Setting Up Spots and Moves</label>
                    <p>This rating evaluates how seamlessly a wrestler sets up spots. It evaluates if the
                    wrestler is in the right place at the right time for a spot as well as readiness for
                        when a spot is going to be performed.</p>
                    <select name="setting_up" id="" class="form-control">
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
                    <label for="bumping">Bumping</label>
                    <p>This rating evaluates a wrestler's intensity and safety in taking bumps <em>inside the ring</em>. This rating
                    does not evaluate how dangerous the bumps are that a wrestler is willing to take, but strictly the execution of taking normal bumps inside the ring.</p>
                    <select name="bumping" id="" class="form-control">
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