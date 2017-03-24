<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
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

    // returns true if user has already given a rating for a particular wrestler
    public function has_rated($wrestler){

        //get all wrestlers user has rated
        $rated_wrestlers = $this->wrestlers();

        if(in_array($wrestler, $rated_wrestlers)){
            return true;
        } else {
            return false;
        }
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

    public function save_user($data){

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->admin = $data['admin'];
        $this->password = bcrypt($data['password']);
        $this->save();
        $image = new Image(['path' => $data['image']]);
        $this->images()->save($image);

       return $this;
    }

    public function update_user($data){
        $this->name = $data['name'];
        $this->email = $data['email'];

        // update admin status if it has been changed
        if(!empty($data['admin'])){
            $this->admin = $data['admin'];
        }

        //update password if it has been changed
        if(!empty($data['password'])){
            $this->password = bcrypt($data['password']);
        }

        $this->save();

        //update image if it has been changed
        if(!empty($data['image'])){
            $this->images[0]->path = $data['image'];
            $this->images[0]->save();
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
                $this->save();

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
                $this->save();

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
}
