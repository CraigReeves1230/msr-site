<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/31/2017
 * Time: 1:20 AM
 */

namespace App\Services\Repositories;


use App\Services\CommunityRatingsEraser;
use App\Wrestler;
use App\WrestlerRating;
use Illuminate\Support\Facades\Auth;

class WrestlerRatingRepository
{

    public function save($rating, $wrestler){

        // this is the user
        $user = Auth::user();

        // Determine if rating will count based on user's status
        if($user->muted == 1) {
            $rating->enabled = false;
        }

        // normalize ratings
        $rating->ratings_normalizer->normalize($rating);

        // calculate overall rating
        $rating->overall_score = round($rating->wrestler_rater->calculate($rating), 2);

        // this will update the rating if rating has already been created
        if(!$user->has_rated_id(session('wrestler_id'))){
            $wrestler = Wrestler::find(session('wrestler_id'));
            $wrestler->ratings()->save($rating);
        } else {
            $this->update();
        }

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $rating->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $rating->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }

    public function update($rating){

        // get the wrestler
        $wrestler = $rating->wrestler;

        // Determine if rating will count based on user status
        if($rating->user->muted == 1) {
            $rating->enabled = false;
        }

        // normalize ratings
        $rating->ratings_normalizer->normalize($rating);

        // calculate overall rating
        $rating->overall_score = round($rating->wrestler_rater->calculate($rating), 2);

        // save the ratings
        $wrestler->ratings()->save($rating);

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $rating->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $rating->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }

    public function delete($rating){

        // get the wrestler to whom the rating belongs
        $wrestler = $rating->wrestler;

        $rating->delete();

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $rating->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $rating->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return WrestlerRating::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return WrestlerRating::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return WrestlerRating::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return WrestlerRating::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return WrestlerRating::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return WrestlerRating::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return WrestlerRating::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return WrestlerRating::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return WrestlerRating::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return WrestlerRating::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return WrestlerRating::where($array)->first();
        }
    }
}