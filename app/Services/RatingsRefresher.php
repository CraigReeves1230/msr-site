<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/31/2017
 * Time: 1:35 PM
 */

namespace App\Services;


use App\Services\Repositories\WrestlerRatingRepository;
use App\Services\Repositories\WrestlerRepository;

class RatingsRefresher
{

    public $wrestler_rating_repository;
    public $community_ratings_compiler;
    public $community_ratings_eraser;
    public $wrestler_rater;
    public $ratings_normalizer;
    public $wrestler_repository;

    public function __construct(CommunityRatingsCompiler $community_ratings_compiler,
                                WrestlerRatingRepository $wrestler_rating_repository,
                                WrestlerRater $wrestler_rater,
                                RatingsNormalizer $ratings_normalizer,
                                WrestlerRepository $wrestler_repository,
                                CommunityRatingsEraser $community_ratings_eraser){

        $this->wrestler_rating_repository = $wrestler_rating_repository;
        $this->community_ratings_compiler = $community_ratings_compiler;
        $this->wrestler_rater = $wrestler_rater;
        $this->ratings_normalizer = $ratings_normalizer;
        $this->wrestler_repository = $wrestler_repository;
        $this->community_ratings_eraser = $community_ratings_eraser;
    }

    public function refresh_ratings(){

        // get all of the ratings
        $ratings = $this->wrestler_rating_repository->all();

        // refresh all the ratings
        foreach($ratings as $rating){

            $this->ratings_normalizer->normalize($rating);
            $this->wrestler_rater->calculate($rating);
            $this->wrestler_rating_repository->update($rating);
        }

        // refresh all the wrestler community ratings
        $wrestlers = $this->wrestler_repository->all();

        // refresh all the wrestler ratings
        foreach($wrestlers as $wrestler){
            $this->community_ratings_eraser->eraseCommunityRatings($wrestler->id);

            // Update community score
            if(count($wrestler->ratings()->where('enabled', true)->get()) >= 3){
                $rating->community_ratings_compiler->compileCommunityRatings($wrestler->id);
            }
        }
    }

}