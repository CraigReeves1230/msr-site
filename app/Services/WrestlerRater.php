<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/28/2017
 * Time: 2:00 PM
 */

namespace App\Services;


use App\Wrestler;

class WrestlerRater
{

    public $ratings_normalizer;

    public function calculate($rateable){

        $execution = $this->calculate_execution($rateable);

        $ability = $this->calculate_ability($rateable);

        $psychology = $this->calculate_psychology($rateable);

        // weighted base average to grade wrestler. Ability and psychology are both
        // 40% and execution is 20%
        $score = (($execution * 20) + ($ability * 40) + ($psychology * 40)) / 100;

        // Now we will filter the score...

        //reward wrestler if all three traits are strong
        if($execution >= 3.25 && $ability >= 3.25 && $psychology >= 3.25) $score += 0.25;

        //reward wrestler again if ability and execution are strong
        if($execution >= 3.25 && $ability >= 3.25) $score += 0.25;

        //reward wrestler again if psychology and execution are exceptional
        if($execution >= 3.50 && $psychology >= 3.50) $score += 0.25;

        //reward wrestler again if all three traits are exceptional. This is an exceptional worker
        if($execution >= 3.50 && $psychology >= 3.50 && $ability >= 3.50) $score += 0.25;

        //score shouldn't exceed 5
        if($score >= 5.0) $score = 5.0;

        //score shouldn't be lower than zero
        if($score <= 0) $score = 0;

        return $score;
    }

    public function calculate_execution($rateable){
        $execution = ($rateable->striking + $rateable->submission + $rateable->throws
                + $rateable->movement + $rateable->mat_and_chain + $rateable->sell_timing
                + $rateable->setting_up + $rateable->bumping) / 8;
        return $execution;
    }

    public function calculate_ability($rateable){
        $ability = ($rateable->technical + $rateable->high_fly + $rateable->power
                + $rateable->reaction + $rateable->durability + $rateable->conditioning
                + $rateable->basing) / 7;
        return $ability;
    }

    public function calculate_psychology($rateable){
        $psychology = ($rateable->shine + $rateable->heat + $rateable->comebacks
                + $rateable->selling + $rateable->ring_awareness) / 5;
        return $psychology;
    }

}