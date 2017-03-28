<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/28/2017
 * Time: 4:09 PM
 */

namespace App\Services;


use App\Rateable;

class RatingsNormalizer
{
    public function normalize($rateable){

        // don't allow transitioning and movement to be
        // more than 0.25 higher than mat/chain
        if($rateable->movement > ($rateable->mat_and_chain + 0.25)) {
            $rateable->movement = $rateable->mat_and_chain + 0.25;
        }

        // don't allow transitioning
        // and movement to be less than 0.25 lower than mat/chain
        if($rateable->movement < ($rateable->mat_and_chain - 0.25)) {
            $rateable->movement = $rateable->mat_and_chain - 0.25;
        }

        // don't let conditioning get more than 0.5 lower than high fly
        if($rateable->conditioning < ($rateable->high_fly - 0.5)){
            $rateable->conditioning = $rateable->high_fly - 0.5;
        }

        // don't let reaction time get 0.5 lower than basing
        if($rateable->reaction < ($rateable->basing - 0.5)){
            $rateable->reaction = $rateable->basing - 0.5;
        }

        // don't let basing get 0.75 lower than durability
        if($rateable->basing < ($rateable->durability - 0.75)){
            $rateable->basing = $rateable->durability - 0.75;
        }

        // don't allow selling to be more than 0.5 lower than ring awareness
        if($rateable->selling < ($rateable->ring_awareness - 0.5)){
            $rateable->selling = $rateable->ring_awareness - 0.5;
        }

        // don't let selling get higher than 1 higher than ring awareness
        if($rateable->selling > ($rateable->ring_awareness + 1)){
            $rateable->selling = $rateable->ring_awareness + 1;
        }

        // don't let shine get lower than 1 below comebacks
        if($rateable->shine < ($rateable->comebacks - 1)){
            $rateable->shine = $rateable->comebacks - 1;
        }

        // don't let comebacks get 1.75 lower than shine
        if($rateable->comebacks < ($rateable->shine - 1.75)){
            $rateable->comebacks = $rateable->shine - 1.75;
        }

        return $rateable;
    }
}