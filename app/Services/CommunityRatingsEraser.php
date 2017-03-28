<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/28/2017
 * Time: 2:35 PM
 */

namespace App\Services;


use App\Wrestler;

class CommunityRatingsEraser
{
    //this function will erase all community ratings, nulling them all out
    public function eraseCommunityRatings($wrestler_id){
        $wrestler = Wrestler::findOrFail($wrestler_id);
        $wrestler->striking = null;
        $wrestler->submission = null;
        $wrestler->throws = null;
        $wrestler->movement = null;
        $wrestler->mat_and_chain = null;
        $wrestler->sell_timing = null;
        $wrestler->setting_up = null;
        $wrestler->bumping = null;
        $wrestler->technical = null;
        $wrestler->high_fly = null;
        $wrestler->power = null;
        $wrestler->reaction = null;
        $wrestler->durability = null;
        $wrestler->conditioning = null;
        $wrestler->basing = null;
        $wrestler->shine = null;
        $wrestler->heat = null;
        $wrestler->comebacks = null;
        $wrestler->selling = null;
        $wrestler->ring_awareness = null;
        $wrestler->community_rating = null;
        $wrestler->save();
    }
}