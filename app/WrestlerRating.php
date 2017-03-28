<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WrestlerRating extends Model
{
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

    //this will compile all ratings in columns into a final rating
    public function calculate_score() {

        //separate ratings into three different sections
        $execution = ($this->striking + $this->submission + $this->throws
                + $this->movement + $this->mat_and_chain + $this->sell_timing
                + $this->setting_up + $this->bumping) / 8;

        $ability = ($this->technical + $this->high_fly + $this->power
                + $this->reaction + $this->durability + $this->conditioning
                + $this->basing) / 7;

        $psychology = ($this->shine + $this->heat + $this->comebacks
                + $this->selling + $this->ring_awareness) / 5;

        // calculate score
        $score = Wrestler::calculate($execution, $ability, $psychology);

        return $score;
    }

    public function normalize(){

        // don't allow transitioning and movement to be
        // more than 0.25 higher than mat/chain
        if($this->movement > ($this->mat_and_chain + 0.25)) {
            $this->movement = $this->mat_and_chain + 0.25;
        }

        // don't allow transitioning
        // and movement to be less than 0.25 lower than mat/chain
        if($this->movement < ($this->mat_and_chain - 0.25)) {
            $this->movement = $this->mat_and_chain - 0.25;
        }

        // don't let conditioning get more than 0.5 lower than high fly
        if($this->conditioning < ($this->high_fly - 0.5)){
            $this->conditioning = $this->high_fly - 0.5;
        }

        // don't let reaction time get 0.5 lower than basing
        if($this->reaction < ($this->basing - 0.5)){
            $this->reaction = $this->basing - 0.5;
        }

        // don't let basing get 0.75 lower than durability
        if($this->basing < ($this->durability - 0.75)){
            $this->basing = $this->durability - 0.75;
        }

        // don't allow selling to be more than 0.5 lower than ring awareness
        if($this->selling < ($this->ring_awareness - 0.5)){
            $this->selling = $this->ring_awareness - 0.5;
        }

        // don't let selling get higher than 1 higher than ring awareness
        if($this->selling > ($this->ring_awareness + 1)){
            $this->selling = $this->ring_awareness + 1;
        }

        // don't let shine get lower than 1 below comebacks
        if($this->shine < ($this->comebacks - 1)){
            $this->shine = $this->comebacks - 1;
        }

        // don't let comebacks get 1.75 lower than shine
        if($this->comebacks < ($this->shine - 1.75)){
            $this->comebacks = $this->shine - 1.75;
        }
    }

    public function save_rating($wrestler){

        // this is the user
        $user = Auth::user();

        // Normalize rating
        $this->normalize();

        // Determine if rating will count based on user's status
       if($user->muted == 1) {
           $this->enabled = false;
       }

        // calculate overall rating
        $this->overall_score = round($this->calculate_score(), 2);

        // this will update the rating if rating has already been created
        if(!$user->has_rated_id(session('wrestler_id'))){
            $wrestler = Wrestler::find(session('wrestler_id'));
            $wrestler->ratings()->save($this);
        } else {
            $this->update();
        }

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            Wrestler::compileCommunityRatings($wrestler->id);
        } else {
            Wrestler::eraseCommunityRatings($wrestler->id);
        }
    }

    public function update_rating($wrestler){

        // Normalize rating
        $this->normalize();

        // Determine if rating will count based on user status
        if($this->user->muted == 1) {
            $this->enabled = false;
        }

        // calculate overall rating
        $this->overall_score = round($this->calculate_score(), 2);

        // save the ratings
        $wrestler->ratings()->save($this);

        // Update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            Wrestler::compileCommunityRatings($wrestler->id);
        } else {
            Wrestler::eraseCommunityRatings($wrestler->id);
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

        // update community score
        if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
            Wrestler::compileCommunityRatings($wrestler->id);
        } else {
            Wrestler::eraseCommunityRatings($wrestler->id);
        }
    }
}
