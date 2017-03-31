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

    public $wrestler_rater;
    public $community_ratings_compiler;
    public $community_ratings_eraser;
    public $ratings_normalizer;

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
