<?php

namespace App;

use App\Services\CommunityRatingsCompiler;
use App\Services\CommunityRatingsEraser;
use App\Services\RatingsNormalizer;
use App\Services\WrestlerRater;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WrestlerRating extends Model
{

    protected $wrestler_rater;
    protected $community_ratings_compiler;
    protected $community_ratings_eraser;
    protected $ratings_normalizer;

    public function __construct()
    {
        $this->wrestler_rater = new WrestlerRater;
        $this->community_ratings_compiler = new CommunityRatingsCompiler;
        $this->ratings_normalizer = new RatingsNormalizer;
        $this->community_ratings_eraser = new CommunityRatingsEraser;
    }

    //returns wrestler the rating belongs to
    public function wrestler(){
        return $this->belongsTo('App\Wrestler');
    }

    // returns user that gave rating
    public function user(){
        return $this->belongsTo('App\User');
    }

    //mass assignment
    protected $fillable = [
        'striking', 'submission', 'throws',
        'movement', 'mat_and_chain', 'sell_timing', 'setting_up',
        'bumping', 'technical', 'high_fly', 'power',
        'reaction', 'durability', 'conditioning',
        'basing', 'shine', 'heat', 'comebacks',
        'selling', 'ring_awareness', 'user_id'
    ];


    public function save_rating($wrestler){

        // this is the user
        $user = Auth::user();

        // Determine if rating will count based on user's status
       if($user->muted == 1) {
           $this->enabled = false;
       }

        // normalize ratings
        $this->ratings_normalizer->normalize($this);

        // calculate overall rating
        $this->overall_score = round($this->wrestler_rater->calculate($this), 2);

        // this will update the rating if rating has already been created
        if(!$user->has_rated_id(session('wrestler_id'))){
            $wrestler = Wrestler::find(session('wrestler_id'));
            $wrestler->ratings()->save($this);
        } else {
            $this->update();
        }

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $this->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $this->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }

    public function update_rating($wrestler){

        // Determine if rating will count based on user status
        if($this->user->muted == 1) {
            $this->enabled = false;
        }

        // normalize ratings
        $this->ratings_normalizer->normalize($this);

        // calculate overall rating
        $this->overall_score = round($this->wrestler_rater->calculate($this), 2);

        // save the ratings
        $wrestler->ratings()->save($this);

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $this->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $this->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }

    public static function workrate_iq($score){
        return round(($score * 10 * 2 + 60), 1);
    }

    public static function colorize_rating($rating){
        if($rating < 2){
            $color = "danger";
        }
        if($rating >= 2 && $rating < 3){
            $color = "warning";
        }
        if($rating >= 3 && $rating < 3.5){
            $color = "success";
        }
        if($rating >= 3.5 && $rating < 4.25){
            $color = "info";
        }
        if($rating >= 4.25){
            $color = "primary";
        }
        return $color;
    }

    public function delete_ratings($wrestler){
        $this->delete();

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            $this->community_ratings_compiler->compileCommunityRatings($wrestler->id);
        } else {
            $this->community_ratings_eraser->eraseCommunityRatings($wrestler->id);
        }
    }
}
