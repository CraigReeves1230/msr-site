<?php

namespace App\Http\Controllers;

use App\Services\Repositories\WrestlerRatingRepository;
use App\Services\Repositories\WrestlerRepository;
use App\WrestlerRating;
use Illuminate\Http\Request;
use App\Wrestler;

class AdminWrestlerRatingsController extends Controller
{

    protected $wrestler_rating_repository;
    protected $wrestler_repository;

    public function __construct(WrestlerRatingRepository $wrestler_rating_repository, WrestlerRepository $wrestler_repository)
    {
        $this->middleware('admin');
        $this->wrestler_rating_repository = $wrestler_rating_repository;
        $this->wrestler_repository = $wrestler_repository;
    }

    public function show($id){
        $wrestler = $this->wrestler_repository->find($id);
        $ratings = $wrestler->ratings()->paginate(12);
        return view('admin.wrestler_ratings.show', compact('wrestler', 'ratings'));
    }

    public function edit($id){
        $ratings = $this->wrestler_rating_repository->find($id);
        $wrestler = $ratings->wrestler;
        return view('admin.wrestler_ratings.edit', compact('ratings', 'wrestler'));
    }

    public function update(Request $request, $id){

        // Save ratings
        $wrestler_ratings = $this->wrestler_rating_repository->find($id);
        $wrestler = $wrestler_ratings->wrestler;

        // obtain ratings
        $wrestler_ratings->striking = $request['striking'];
        $wrestler_ratings->submission = $request['submission'];
        $wrestler_ratings->throws = $request['throws'];
        $wrestler_ratings->movement = $request['movement'];
        $wrestler_ratings->mat_and_chain = $request['mat_and_chain'];
        $wrestler_ratings->sell_timing = $request['sell_timing'];
        $wrestler_ratings->setting_up = $request['setting_up'];
        $wrestler_ratings->bumping = $request['bumping'];
        $wrestler_ratings->technical = $request['technical'];
        $wrestler_ratings->high_fly = $request['high_fly'];
        $wrestler_ratings->power = $request['power'];
        $wrestler_ratings->reaction = $request['reaction'];
        $wrestler_ratings->durability = $request['durability'];
        $wrestler_ratings->conditioning = $request['conditioning'];
        $wrestler_ratings->basing = $request['basing'];
        $wrestler_ratings->shine = $request['shine'];
        $wrestler_ratings->heat = $request['heat'];
        $wrestler_ratings->comebacks = $request['comebacks'];
        $wrestler_ratings->selling = $request['selling'];
        $wrestler_ratings->ring_awareness = $request['ring_awareness'];
        if($request['enabled'] == "on") {
            $wrestler_ratings->enabled = 1;
        } else {
            $wrestler_ratings->enabled = 0;
        }

        // save ratings
        $this->wrestler_rating_repository->update($wrestler_ratings);
        return redirect("admin/wrestler_ratings/{$wrestler->id}");
    }

    public function delete_ratings($id){

        // get ratings
        $ratings = $this->wrestler_rating_repository->find($id);

        $this->wrestler_rating_repository->delete($ratings);
        return redirect()->back();
    }

}
