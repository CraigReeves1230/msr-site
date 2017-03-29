<?php

namespace App\Http\Controllers;

use App\Services\RatingConverter;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\MatchRater;

class MatchRaterController extends Controller
{
    public function post($id){
        $post = Post::find($id);
        return view('main/post', compact('post'));
    }

    public function ratingtool1(){
        return view('main/match_rater/mrt_page1');
    }

    public function ratingtool2(Request $request){
        session()->put($request->all());
        return view('main/match_rater/mrt_page2');
    }

    public function ratingtool3(Request $request, RatingConverter $rating_converter){

        session()->put($request->all());
        $match = new MatchRater;
        $match->offense = session('offense');
        $match->timing = session('timing');
        $match->movement = session('movement');
        $match->action = session('action');
        $match->crowd = session('crowd');
        $match->excitement = session('excitement');
        $match->selling = session('selling');
        $match->time = session('time');
        $match->story = session('story');
        $score = $match->calculate_score();
        session(['score' => $score]);

        return view('main/match_rater/mrt_page3', compact('score', 'rating_converter'));
    }

    public function ratingtool4(Request $request, RatingConverter $rating_converter){

        // calculate final score
        $choice = $request['choice'];
        $score = session('score');
        switch($choice) {
            case "high";
                $score -= 0.25;
                break;

            case "low";
                $score += 0.25;
                break;

            default:
                $score = $score;
                break;
        }
        $star_rating = $rating_converter->convertToStarRating($score);
        return view('main/match_rater/mrt_page4', compact('star_rating', 'rating_converter'));
    }

}
