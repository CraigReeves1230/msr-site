<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'admin', 'status', 'summary', 'new_alerts', 'new_messages', 'reset_digest',
        'reset_digest_time'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function post_previews(){
        return $this->hasMany('App\PostPreview');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function ratings() {
        return $this->hasMany('App\WrestlerRating');
    }

    public function private_messages(){
        return $this->hasMany('App\PrivateMessage');
    }

    //returns images for user
    public function images() {
        return $this->morphMany('App\Image', 'imageable');
    }

    // returns an array of all wrestlers user has given ratings to
    public function wrestlers(){

        //get all wrestler ratings
        $ratings = $this->ratings;

        // create array we will store all wrestlers into
        $wrestlers_array = [];

        //grab all wrestlers whom those ratings belong
        for($i = 0; $i < count($ratings); $i++){
            $wrestlers_array[$i] = $ratings[$i]->wrestler;
        }

        return $wrestlers_array;
    }

    // returns an array of all wrestlers user has given ratings to
    public function wrestlers_paginated($pagination){

        //get all wrestler ratings
        $ratings = $this->ratings;

        // create array we will store all wrestlers into
        $wrestlers_array = [];

        //grab all wrestler ids whom those ratings belong
        for($i = 0; $i < count($ratings); $i++){
            $wrestlers_array[$i] = $ratings[$i]->wrestler->id;
        }

        // pull from the database and paginate
        $wrestlers = Wrestler::whereIn('id', $wrestlers_array)->paginate($pagination);

        return $wrestlers;
    }

    // returns true if user has already given a rating for a particular wrestler
    public function has_rated($wrestler){

        // get the wrestler by the id
        $wrestler = Wrestler::find($wrestler->id);

        //get all wrestlers user has rated
        $rated_wrestlers = $this->wrestlers();

        if(in_array($wrestler, $rated_wrestlers)){
            return true;
        } else {
            return false;
        }

    }

    // favorite a wrestler
    public function favorite($wrestler){
        DB::table('wrestler_favorites')->insert(['user_id' => $this->id, 'wrestler_id' => $wrestler->id]);
    }

    // unfollow a wrestler
    public function unfollow($wrestler){
        DB::table('wrestler_favorites')->where(['user_id' => $this->id, 'wrestler_id' => $wrestler->id])->delete();
    }

    // gets all wrestlers favorited
    public function favorites(){
        $ids = DB::table('wrestler_favorites')->select('wrestler_id')->where('user_id', $this->id)->get();

        $id_array = [];
        for($i = 0; $i < count($ids); $i++){
            array_push($id_array, get_object_vars($ids[$i]));
        }
        $wrestlers = Wrestler::whereIn('id', $id_array)->get();
        return $wrestlers;
    }

    // gets all wrestlers favorited, paginated
    public function favorites_paginated($pagination){
        $ids = DB::table('wrestler_favorites')->select('wrestler_id')->where('user_id', $this->id)->get();

        $id_array = [];
        for($i = 0; $i < count($ids); $i++){
            array_push($id_array, get_object_vars($ids[$i]));
        }
        $wrestlers = Wrestler::whereIn('id', $id_array)->paginate($pagination);
        return $wrestlers;
    }

    // returns true if a wrestler is favorited
    public function does_follow($wrestler){
        return $this->favorites()->contains($wrestler->id);
    }

    // returns true if user has already given a rating for a particular wrestler by id
    public function has_rated_id($wrestler_id){

        // get the wrestler by the id
        $wrestler = Wrestler::find($wrestler_id);

        //get all wrestlers user has rated
        $rated_wrestlers = $this->wrestlers();

        if(in_array($wrestler, $rated_wrestlers)){
            return true;
        } else {
            return false;
        }
    }

    // returns the ratings for a particular wrestler that has been rated
    public function get_ratings_for($wrestler){

        if($this->has_rated($wrestler)){
            return $wrestler->ratings()->where('user_id', $this->id)->first();
        } else {
            return null;
        }
    }

    // Bans a user
    public function ban(){

        // get the user who is doing the banning
        $logged_in_user = Auth::user();

        // safeguards
        if($this->status == "active") {

            // make sure the user being banned can be banned
            if($this->admin == 0 || $logged_in_user->master == 1) {

                $this->status = "banned";
                $this->muted = 1;
                $this->update();

                // send alert to user
                Alert::send_alert($this, "Banned", "danger", "Your account has been banned by " . $logged_in_user->name . ".", "#");

                // put this log into the user bans table
                DB::table('user_bans')->insert(['user_id' => $this->id, 'admin_id' => $logged_in_user->id]);
            } else {
                Session::flash('cannot_ban', 'You do not have permission to ban an administrator.');
            }
        } else {
            Session::flash('already_banned', 'This user is already banned.');
        }
    }

    // Reinstates a user
    public function reinstate(){

        // get the user who is attempting the reinstating
        $logged_in_user = Auth::user();

        // get the admin of the original ban
        $original_ban = DB::table('user_bans')->where('user_id', $this->id)->first();
        $admin_id = $original_ban->admin_id;

        // safeguards
        if($this->status == "banned") {

            // make sure only the user who did the banning can do the reinstating. That or the owner.
            if($logged_in_user-> id == $admin_id || $logged_in_user->master == 1) {

                $this->status = "active";
                $this->muted = 0;
                $this->update();

                // send alert to user
                Alert::send_alert($this, "Account Reactivated", "success", "Your account has been reactivated by " . $logged_in_user->name . ".", "#");

                // remove log from the user bans table
                DB::table('user_bans')->where('user_id', $this->id)->delete();
            } else {
                Session::flash('cannot_reinstate', 'You are only allowed to reinstate users you have banned.');
            }
        } else {
            Session::flash('alrady_active', 'This user is already active.');
        }
    }

    // returns the ratings for a particular wrestler that has been rated by id
    public function get_ratings_for_id($wrestler_id){

        // get the wrestler by the id
        $wrestler = Wrestler::find($wrestler_id);

        if($this->has_rated($wrestler)){
            return $wrestler->ratings()->where('user_id', $this->id)->first();
        } else {
            return null;
        }
    }

    // returns all user's alerts
    public function alerts(){
        return $this->hasMany('App\Alert');
    }

    // returns true if user is blocked by another user
	public static function is_blocked($messenger, $user){
    	// look for paring in database and determine if it is true
		if($set = DB::table('pm_blocks')->where([['messenger_id', $messenger->id], ['user_id', $user->id]])->first()){
			return true;
		} else {
			return false;
		}
	}





}
