<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentReply;
use App\Services\Gateways\CommentsGateway;
use App\Services\RatingConverter;
use App\Services\Repositories\CommentReplyRepository;
use App\Services\Repositories\CommentsRepository;
use App\Services\Repositories\WrestlerRepository;
use App\Services\WrestlerRater;
use App\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWrestlersController extends Controller
{

    protected $wrestler_repository;

    public function __construct(WrestlerRepository $wrestler_repository)
    {
        $this->middleware('auth');
        $this->wrestler_repository = $wrestler_repository;
    }

    public function show($id, WrestlerRater $wrestler_rater, RatingConverter $rating_converter)
    {

        $wrestler = $this->wrestler_repository->find($id);

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

        return view('wrestler_profile.show', compact('user', 'wrestler', 'rating_converter', 'execution', 'user_score',
            'psychology', 'ability', 'score', 'user_execution', 'user_ability', 'user_psychology', 'comments'));
    }

    public function store_comment(Request $request, CommentsGateway $gateway, CommentsRepository $comments_repository){
        $user = Auth::user();
        $data = $request->all();
        $wrestler = $this->wrestler_repository->find($data['wrestler_id']);

        // gateway to access
        if($gateway->enact($user)){
            return redirect()->back();
        }

        $comments_repository->save($wrestler, $data);
        return redirect()->back();
    }

    public function store_reply(Request $request, CommentsGateway $gateway, CommentReplyRepository $reply_repository){
        $user = Auth::user();
        $data = $request->all();

        // gateway to access
        if($gateway->enact($user)){
            return redirect()->back();
        }

        $reply_repository->save($data);
        return redirect()->back();
    }

    public function favorite($id){
        $user = Auth::user();
        $wrestler = $this->wrestler_repository->find($id);
        $user->favorite($wrestler);
        return redirect('wres_profile/' . $id);
    }

    public function unfollow($id){
        $user = Auth::user();
        $wrestler = $this->wrestler_repository->find($id);
        $user->unfollow($wrestler);
        return redirect('wres_profile/' . $id);
    }


}

