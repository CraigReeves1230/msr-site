<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Wrestler;
use App\WrestlerRating;
use App\AltName;
use Illuminate\Support\Facades\Auth;

class WrestlerRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function wres_search()
    {
        return view('main/wres_rater/search/select_wrestler_for_rating');
    }

    public function wres_search_results(Request $request)
    {
        return view('main/wres_rater/search/select_wrestler_results');
    }

    public function new_rating_go($id)
    {
        session(['wrestler_id' => $id]);
        return view('main/wres_rater/new_rating/wrestler_rater');
    }

    public function search_result(Request $request)
    {

        $search_query = $request['search_wrestler'];

        // get logged_in_user
        $logged_in_user = Auth::user();

        // look for wrestler in database and populate search results
        if ($alt_name = AltName::where("name", "LIKE", "%$search_query%")->first()) {
            $wrestlers = $alt_name->wrestlers;
            return view('main/wres_rater/search/select_wrestler_results', compact('wrestlers', 'search_query', 'logged_in_user'));
        } else {
            $wrestlers = [];
            return view('main/wres_rater/search/select_wrestler_results', compact('wrestlers', 'search_query'));
        }
    }

    public function new_rating2(Request $request)
    {

        // gather ratings
        session(['striking' => $request['striking']]);
        session(['submission' => $request['submission']]);
        session(['throws' => $request['throws']]);
        session(['movement' => $request['movement']]);
        session(['mat_and_chain' => $request['mat_and_chain']]);
        session(['sell_timing' => $request['sell_timing']]);
        session(['setting_up' => $request['setting_up']]);
        session(['bumping' => $request['bumping']]);

        return view('main/wres_rater/new_rating/wrestler_rater2');
    }

    public function new_rating3(Request $request)
    {

        // gather ratings
        session(['technical' => $request['technical']]);
        session(['high_fly' => $request['high_fly']]);
        session(['power' => $request['power']]);
        session(['conditioning' => $request['conditioning']]);
        session(['reaction' => $request['reaction']]);
        session(['durability' => $request['durability']]);
        session(['basing' => $request['basing']]);

        return view('main/wres_rater/new_rating/wrestler_rater3');
    }

    public function new_rating4(Request $request)
    {

        // gather ratings
        session(['shine' => $request['shine']]);
        session(['heat' => $request['heat']]);
        session(['comebacks' => $request['comebacks']]);
        session(['selling' => $request['selling']]);
        session(['ring_awareness' => $request['ring_awareness']]);

        // get wrestler whom we are rating
        $wrestler = Wrestler::findOrFail(session('wrestler_id'));

        // store ratings to new rating if wrestler has not been rated by user
        if (!Auth::user()->has_rated_id($wrestler->id)) {
            $wrestler_rating = new WrestlerRating;
        } else {
            $wrestler_rating = Auth::user()->get_ratings_for_id($wrestler->id);
        }

        // Assign ratings from fields
        $wrestler_rating->striking = session('shine');
        $wrestler_rating->submission = session('submission');
        $wrestler_rating->throws = session('throws');
        $wrestler_rating->movement = session('movement');
        $wrestler_rating->mat_and_chain = session('mat_and_chain');
        $wrestler_rating->sell_timing = session('sell_timing');
        $wrestler_rating->setting_up = session('setting_up');
        $wrestler_rating->bumping = session('bumping');
        $wrestler_rating->technical = session('technical');
        $wrestler_rating->high_fly = session('high_fly');
        $wrestler_rating->power = session('power');
        $wrestler_rating->reaction = session('reaction');
        $wrestler_rating->durability = session('durability');
        $wrestler_rating->conditioning = session('conditioning');
        $wrestler_rating->basing = session('basing');
        $wrestler_rating->shine = session('shine');
        $wrestler_rating->heat = session('heat');
        $wrestler_rating->comebacks = session('comebacks');
        $wrestler_rating->selling = session('selling');
        $wrestler_rating->ring_awareness = session('ring_awareness');
        $wrestler_rating->user_id = Auth::user()->id;

        // save wrestler
        $wrestler_rating->save_rating($wrestler);

        return redirect('user_profile/my_wrestlers');
    }

    public function edit_rating1($id)
    {
        // get the user
        $user = Auth::user();

        // get the wrestler being edited
        $wrestler = Wrestler::findOrFail($id);

        // get the ratings
        $ratings = $user->ratings()->where('wrestler_id', $id)->first();

        return view('main.wres_rater.edit_rating.edit_rating1', compact('ratings', 'user', 'wrestler'));
    }

    public function edit_rating2(Request $request, $id)
    {

        // store ratings into session
        session(['striking' => $request['striking']]);
        session(['submission' => $request['submission']]);
        session(['throws' => $request['throws']]);
        session(['movement' => $request['movement']]);
        session(['mat_and_chain' => $request['mat_and_chain']]);
        session(['sell_timing' => $request['sell_timing']]);
        session(['setting_up' => $request['setting_up']]);
        session(['bumping' => $request['bumping']]);

        // get the user
        $user = Auth::user();

        // get the wrestler being edited
        $wrestler = Wrestler::findOrFail($id);

        // get the ratings
        $ratings = $user->ratings()->where('wrestler_id', $id)->first();

        return view('main.wres_rater.edit_rating.edit_rating2', compact('ratings', 'wrestler', 'user'));

    }

    public function edit_rating3(Request $request, $id)
    {

        // store ratings into session
        session(['technical' => $request['technical']]);
        session(['high_fly' => $request['high_fly']]);
        session(['power' => $request['power']]);
        session(['reaction' => $request['reaction']]);
        session(['durability' => $request['durability']]);
        session(['conditioning' => $request['conditioning']]);
        session(['basing' => $request['basing']]);

        // get the user
        $user = Auth::user();

        // get the wrestler being edited
        $wrestler = Wrestler::findOrFail($id);

        // get the ratings
        $ratings = $user->ratings()->where('wrestler_id', $id)->first();

        return view('main.wres_rater.edit_rating.edit_rating3', compact('ratings', 'wrestler', 'user'));
    }

    public function edit_rating4(Request $request, $id)
    {

        // gather ratings
        session(['shine' => $request['shine']]);
        session(['heat' => $request['heat']]);
        session(['comebacks' => $request['comebacks']]);
        session(['selling' => $request['selling']]);
        session(['ring_awareness' => $request['ring_awareness']]);

        // get the user
        $user = Auth::user();

        // get the wrestler being edited
        $wrestler = Wrestler::findOrFail($id);

        // get the ratings
        $wrestler_rating = $user->ratings()->where('wrestler_id', $id)->first();

        // update the ratings
        $wrestler_rating->striking = session('shine');
        $wrestler_rating->submission = session('submission');
        $wrestler_rating->throws = session('throws');
        $wrestler_rating->movement = session('movement');
        $wrestler_rating->mat_and_chain = session('mat_and_chain');
        $wrestler_rating->sell_timing = session('sell_timing');
        $wrestler_rating->setting_up = session('setting_up');
        $wrestler_rating->bumping = session('bumping');
        $wrestler_rating->technical = session('technical');
        $wrestler_rating->high_fly = session('high_fly');
        $wrestler_rating->power = session('power');
        $wrestler_rating->reaction = session('reaction');
        $wrestler_rating->durability = session('durability');
        $wrestler_rating->conditioning = session('conditioning');
        $wrestler_rating->basing = session('basing');
        $wrestler_rating->shine = session('shine');
        $wrestler_rating->heat = session('heat');
        $wrestler_rating->comebacks = session('comebacks');
        $wrestler_rating->selling = session('selling');
        $wrestler_rating->ring_awareness = session('ring_awareness');

        // save wrestler
        $wrestler_rating->update_rating($wrestler);

        // redirect
        return redirect('wres_profile/' . $wrestler->id);

    }

}
