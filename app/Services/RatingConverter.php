<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/28/2017
 * Time: 7:52 PM
 */

namespace App\Services;


class RatingConverter
{

    // converts a score to a star rating
    public function convertToStarRating($score) {

        //initialize value
        $value = '';

        if($score < 0.25){
            $value = "DUD";
        }
        if($score >= 0.25 && $score < 0.5){
            $value = "1/4*";
        }
        if($score >= 0.50 && $score < 0.75){
            $value = "1/2*";
        }
        if($score >= 0.75 && $score < 1.0){
            $value = "3/4*";
        }
        if($score >= 1.0 && $score < 1.25){
            $value = "*";
        }
        if($score >= 1.25 && $score < 1.50){
            $value = "*1/4";
        }
        if($score >= 1.50 && $score < 1.75){
            $value = "*1/2";
        }
        if($score >= 1.75 && $score < 2.0){
            $value = "*3/4";
        }
        if($score >= 2.0 && $score < 2.25){
            $value = "**";
        }
        if($score >= 2.25 && $score < 2.5){
            $value = "**1/4";
        }
        if($score >= 2.50 && $score < 2.75){
            $value = "**1/2";
        }
        if($score >= 2.75 && $score < 3.0){
            $value = "**3/4";
        }
        if($score >= 3.0 && $score < 3.25){
            $value = "***";
        }
        if($score >= 3.25 && $score < 3.5){
            $value = "***1/4";
        }
        if($score >= 3.5 && $score < 3.75){
            $value = "***1/2";
        }
        if($score >= 3.75 && $score < 4.0){
            $value = "***3/4";
        }
        if($score >= 4.0 && $score < 4.25){
            $value = "****";
        }
        if($score >= 4.25 && $score < 4.5){
            $value = "****1/4";
        }
        if($score >= 4.5 && $score < 4.75){
            $value = "****1/2";
        }
        if($score >= 4.75 && $score < 4.90){
            $value = "****3/4";
        }
        if($score >= 4.9){
            $value = "*****";
        }

        return $value;
    }

    // converts a score to a workrate score comparable to an IQ score
    public function workrate_iq($score){
        return round(($score * 10 * 2 + 60), 1);
    }

    // Converts rating into color
    public function colorize_rating($rating){
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

}