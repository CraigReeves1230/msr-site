<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use App\Services\WrestlerRater;
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

    public function show($id, WrestlerRater $wrestler_rater)
    {

        $wrestler = Wrestler::findOrFail($id);

        //calculate community scores

        //calculate execution
        $execution = round($wrestler_rater->calculate_execution($wrestler), 1) ;

        //calculate ability
        $ability = round($wrestler_rater->calculate_ability($wrestler), 1);

        //calculate psych
        $psychology = round($wrestler_rater->calculate_psychology($wrestler), 1);

        // get score
        $score = round($wrestler->community_rating, 1);

        // if these are not applicable, make "N/A"
        if ($execution == 0) $execution = 'N/A';
        if ($ability == 0) $ability = 'N/A';
        if ($psychology == 0) $psychology = 'N/A';
        if ($score == 0) $score = 'N/A';

        // get ratings user gave wrestler if user did give ratings to wrestler.
        $user = Auth::user();

        if ($user_ratings = $user->ratings()->where('wrestler_id', $wrestler->id)->first()) {

            //calculate user execution
            $user_execution = round($wrestler_rater->calculate_execution($user_ratings), 1);

            //calculate user ability
            $user_ability = round($wrestler_rater->calculate_ability($user_ratings), 1);

            //calculate user psych
            $user_psychology = round($wrestler_rater->calculate_psychology($user_ratings), 1);

            //get user score
            $user_score = round($user->ratings()->where('wrestler_id', $wrestler->id)->first()->overall_score, 1);

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

