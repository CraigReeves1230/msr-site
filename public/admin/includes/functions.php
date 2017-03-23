<?php
include "db.php";

function queryDatabase($query_string) {
    
    global $database;
    $result = mysqli_query($database, $query_string);
    if($result){
        // do nothing because it worked
    } else {
        die("Database Query Failed. " . mysqli_error($database));
    }
    return $result;
}

function calculateScore() {
     
    // set default value for factoring_heat
    $factoring_heat = 1;
    // set default score
    $score = 2.5;

    // Get varaibles from form
    $offense = $_POST['offense'];
    $timing = $_POST['timing'];
    $movement = $_POST['movement'];
    $action = $_POST['action'];
    $excitement = $_POST['excitement'];
    $time = $_POST['time'];
    $story = $_POST['story'];
    $selling = $_POST['selling'];
    $crowd = $_POST['crowd'];

    // average up main scores
    $execution = ($offense + $timing + $movement) / 3;
    $difficulty = ($action + $excitement) / 2;
    $psychology = ($story + $selling + $time) / 3;

    // determine if factoring heat
    if($crowd == 99.0) {
        $factoring_heat = 0;
    } else {
        $factoring_heat = 1;
    }

    // calculate score
  
    // come up with base average
    if($factoring_heat) {
        $score = ($execution + $crowd + $difficulty + $psychology) / 4;
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
        if($crowd > 3.0 && $psychology >= 3.0 && $difficulty >= 3.0) {
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
        if($crowd > 4.0 && $psychology >= 4.0 && $psychology >= 3.0){
            $score += 0.50;
        }
    }

    // If execution is exemplary, reward performers greatly but only if match is strong
    if($execution >= 4.5 && $score >= 3.5) {
        $score += 0.25;
    }
    return $score;
}

function convertToStarRating($score) {
    
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









































