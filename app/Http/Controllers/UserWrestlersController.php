<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use App\Wrestler;
use App\WrestlerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWrestlersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {

        $wrestler = Wrestler::findOrFail($id);

        //calculate community scores

        //calculate execution
        $execution = round(($wrestler->striking + $wrestler->submission + $wrestler->throws +
                $wrestler->movement + $wrestler->mat_and_chain + $wrestler->setting_up +
                $wrestler->bumping + $wrestler->sell_timing) / 8, 1) ;

        //calculate ability
        $ability = round(($wrestler->technical + $wrestler->high_fly + $wrestler->power +
                $wrestler->reaction + $wrestler->durability + $wrestler->conditioning +
                $wrestler->basing) / 7, 1);

        //calculate psych
        $psychology = round(($wrestler->shine + $wrestler->heat + $wrestler->comebacks + $wrestler->selling
                + $wrestler->ring_awareness) / 5, 1);

        // get score
        $score = $wrestler->community_rating;

        // if these are not applicable, make "N/A"
        if ($execution == 0) $execution = 'N/A';
        if ($ability == 0) $ability = 'N/A';
        if ($psychology == 0) $psychology = 'N/A';
        if ($score == 0) $score = 'N/A';

        // get ratings user gave wrestler if user did give ratings to wrestler.
        $user = Auth::user();

        if ($user_ratings = $user->ratings()->where('wrestler_id', $wrestler->id)->first()) {

            //calculate user execution
            $user_execution = round(($user_ratings->striking + $user_ratings->submission + $user_ratings->throws +
                    $user_ratings->movement + $user_ratings->mat_and_chain + $user_ratings->setting_up +
                    $user_ratings->bumping + $user_ratings->sell_timing) / 8, 1);

            //calculate user ability
            $user_ability = round(($user_ratings->technical + $user_ratings->high_fly + $user_ratings->power +
                    $user_ratings->reaction + $user_ratings->durability + $user_ratings->conditioning +
                    $user_ratings->basing) / 7, 1);

            //calculate user psych
            $user_psychology = round(($user_ratings->shine + $user_ratings->heat +
                    $user_ratings->comebacks + $user_ratings->selling
                    + $user_ratings->ring_awareness) / 5, 1);

            //get user score
            $user_score = WrestlerRating::where('user_id', $user->id)->first()->overall_score;

            // if these are not applicable, make "N/A"
            if ($user_execution == 0) $execution = 'N/A';
            if ($user_ability == 0) $ability = 'N/A';
            if ($user_psychology == 0) $psychology = 'N/A';
            if ($user_score == 0) $score = 'N/A';

        } else {
            $user_execution = "N/A";
            $user_ability = "N/A";
            $user_psychology = "N/A";
            $user_score = "N/A";
        }

        // get wrestler comments
        $comments = $wrestler->comments;

        return view('wrestler_profile.show', compact('user', 'wrestler', 'execution', 'user_score',
            'psychology', 'ability', 'score', 'user_execution', 'user_ability', 'user_psychology', 'comments'));
    }

    public function store_comment(Comment $comment, Request $request){
        $data = $request->all();
        $wrestler = Wrestler::findOrFail($data['wrestler_id']);
        $comment->save_comment($wrestler, $data);
        return redirect()->back();
    }

    public function store_reply(CommentReply $reply, Request $request){
        $data = $request->all();
        $reply->save_reply($data);
        return redirect()->back();
    }

    public function favorite($id){
        $user = Auth::user();
        $wrestler = Wrestler::findOrFail($id);
        $user->favorite($wrestler);
        return redirect('wres_profile/' . $id);
    }

    public function unfollow($id){
        $user = Auth::user();
        $wrestler = Wrestler::findOrFail($id);
        $user->unfollow($wrestler);
        return redirect('wres_profile/' . $id);
    }

}

