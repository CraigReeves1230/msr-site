<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 6/23/2017
 * Time: 5:46 PM
 */

namespace App\Services;


class MatchRater
{
    //match statistics
    public $offense;
    public $timing;
    public $movement;
    public $action;
    public $excitement;
    public $time;
    public $story;
    public $selling;
    public $crowd;

    //calculate match score
    public function calculate_score(){

        //Determine if factoring heat
        if($this->crowd == 99.0) {
            $factoring_heat = 0;
        } else {
            $factoring_heat = 1;
        }

        // Determine main scores
        $execution = ($this->offense + $this->timing + $this->movement) / 3;
        $difficulty = ($this->action + $this->excitement) / 2;
        $psychology = ($this->story + $this->selling + $this->time) / 3;

        // come up with base average
        if($factoring_heat) {
            $score = ($execution + $this->crowd + $difficulty + $psychology) / 4;
        } else {
            $score = ($execution + $difficulty + $psychology) / 3;
        }

        // If the execution is poor, punish performers harshly
        if($execution < 2.0) {
            $score -= 1.5;
        }

        // If execution is great, reward performers greatly but only if athleticism is strong
        if($execution >= 4.0 && $difficulty >= 3.0) {
            $score += 0.25;
        }

        // If the crowd is hot for the match and the story is good, reward match but only
        // if difficulty too is strong
        if($factoring_heat){
            if($this->crowd > 3.0 && $psychology >= 3.0 && $difficulty >= 3.0) {
                $score += 0.25;
            }
        }

        // If the action is better than average and the execution is not, this tells
        // us that it was probably sloppy
        if($execution <= 2.0 && $difficulty > 2.25){
            $score -= 0.25;
        }

        // If the execution is very good and the action is too, reward performers
        if($execution > 3.25 && $difficulty > 3.25){
            $score += 0.25;
        }

        // If the heat is incredible and the match is great, reward match generously
        if($factoring_heat){
            if($this->crowd > 4.0 && $psychology >= 4.0 && $psychology >= 3.0){
                $score += 0.50;
            }
        }

        // If execution is exemplary, reward performers greatly but only if match is strong
        if($execution >= 4.5 && $score >= 3.5) {
            $score += 0.25;
        }
        return $score;
    }
}