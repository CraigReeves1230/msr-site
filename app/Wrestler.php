<?php

namespace App;

use App\Services\WrestlerRater;
use Illuminate\Database\Eloquent\Model;
use App\WrestlerRating;
use Illuminate\Support\Facades\DB;

class Wrestler extends Model
{

    protected $wrestler_rater;

    public function __construct(){
            $this->wrestler_rater = new WrestlerRater;
    }

    //mass assignment
    protected $fillable = [
        'name', 'striking', 'submission', 'throws',
        'movement', 'mat_and_chain', 'sell_timing', 'setting_up',
        'bumping', 'technical', 'high_fly', 'power',
        'reaction', 'durability', 'conditioning',
        'basing', 'shine', 'heat', 'comebacks',
        'selling', 'ring_awareness', 'community_rating', 'bio',
        'twitter', 'instagram', 'gender'
    ];

    //returns images for wrestler
    public function images() {
        return $this->morphMany('App\Image', 'imageable');
    }

    //returns alt names for wrestler
    public function alt_names(){
        return $this->belongsToMany('App\AltName');
    }

    //simple way to get a photo
    public function get_image() {
        if(!empty($this->images[0])) {
            return $this->images[0]->path;
        }
    }

    //returns all ratings given to wrestler
    public function ratings() {
        return $this->hasMany('App\WrestlerRating');
    }

    // returns comments for wrestler
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    //this function will automatically compile all ratings into community ratings
    public static function compileCommunityRatings($id) {

        $wrestler_rater = new WrestlerRater;

        // get wrestler
        $wrestler = Wrestler::findOrFail($id);

        // zero out all ratings
        $wrestler->striking = 0;
        $wrestler->submission = 0;
        $wrestler->throws = 0;
        $wrestler->movement = 0;
        $wrestler->mat_and_chain = 0;
        $wrestler->setting_up = 0;
        $wrestler->sell_timing = 0;
        $wrestler->bumping = 0;
        $wrestler->technical = 0;
        $wrestler->high_fly = 0;
        $wrestler->power = 0;
        $wrestler->reaction = 0;
        $wrestler->durability = 0;
        $wrestler->conditioning = 0;
        $wrestler->basing = 0;
        $wrestler->shine = 0;
        $wrestler->heat = 0;
        $wrestler->comebacks = 0;
        $wrestler->selling = 0;
        $wrestler->ring_awareness = 0;

        // filter out enabled ratings
        $enabled_ratings = [];
        foreach($wrestler->ratings as $rating){
            if($rating->enabled){
                array_push($enabled_ratings, $rating);
            }
        }

        // add all ratings up
        foreach ($enabled_ratings as $rating){
            $wrestler->striking += $rating->striking;
            $wrestler->submission += $rating->submission;
            $wrestler->throws += $rating->throws;
            $wrestler->movement += $rating->throws;
            $wrestler->mat_and_chain += $rating->mat_and_chain;
            $wrestler->setting_up += $rating->setting_up;
            $wrestler->sell_timing += $rating->sell_timing;
            $wrestler->bumping += $rating->bumping;
            $wrestler->technical += $rating->technical;
            $wrestler->high_fly += $rating->high_fly;
            $wrestler->power += $rating->power;
            $wrestler->reaction += $rating->reaction;
            $wrestler->durability += $rating->durability;
            $wrestler->conditioning += $rating->conditioning;
            $wrestler->basing += $rating->basing;
            $wrestler->shine += $rating->shine;
            $wrestler->heat += $rating->heat;
            $wrestler->comebacks += $rating->comebacks;
            $wrestler->selling += $rating->selling;
            $wrestler->ring_awareness += $rating->ring_awareness;
        }

        // average all ratings
        $wrestler->striking = round($wrestler->striking / count($enabled_ratings), 2);
        $wrestler->submission = round($wrestler->submission / count($enabled_ratings), 2);
        $wrestler->throws = round($wrestler->throws / count($enabled_ratings), 2);
        $wrestler->movement = round($wrestler->movement / count($enabled_ratings), 2);
        $wrestler->mat_and_chain = round($wrestler->mat_and_chain / count($enabled_ratings), 2);
        $wrestler->setting_up = round($wrestler->setting_up / count($enabled_ratings), 2);
        $wrestler->sell_timing = round($wrestler->sell_timing / count($enabled_ratings), 2);
        $wrestler->bumping = round($wrestler->bumping / count($enabled_ratings), 2);
        $wrestler->technical = round($wrestler->technical / count($enabled_ratings), 2);
        $wrestler->high_fly = round($wrestler->high_fly / count($enabled_ratings), 2);
        $wrestler->power = round($wrestler->power / count($enabled_ratings), 2);
        $wrestler->reaction = round($wrestler->reaction / count($enabled_ratings), 2);
        $wrestler->durability = round($wrestler->durability / count($enabled_ratings), 2);
        $wrestler->conditioning = round($wrestler->conditioning / count($enabled_ratings), 2);
        $wrestler->basing = round($wrestler->basing / count($enabled_ratings), 2);
        $wrestler->shine = round($wrestler->shine / count($enabled_ratings), 2);
        $wrestler->heat = round($wrestler->heat / count($enabled_ratings), 2);
        $wrestler->comebacks = round($wrestler->comebacks / count($enabled_ratings), 2);
        $wrestler->selling = round($wrestler->selling / count($enabled_ratings), 2);
        $wrestler->ring_awareness = round($wrestler->ring_awareness / count($enabled_ratings), 2);

        // get the community score
        $comm_score = $wrestler_rater->calculate($wrestler);
        $wrestler->community_rating = round($comm_score, 2);

        // save the wrestler
        $wrestler->save();
    }

    // returns all users who have favorited this wrestler
    public function followers(){
        $ids = DB::table('wrestler_favorites')->select('user_id')->where('wrestler_id', $this->id)->get();

        $id_array = [];
        for($i = 0; $i < count($ids); $i++){
            array_push($id_array, get_object_vars($ids[$i]));
        }
        $users = User::whereIn('id', $id_array)->get();
        return $users;
    }

    // returns true if a particular user follows this wrestler
    public function is_followed_by($user){
        return $this->followers()->contains($user->id);
    }
}
