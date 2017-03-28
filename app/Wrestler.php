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

    public function save_wrestler($request){

        $this->name = $request['name'];

        // Alt name fields
        $alt_name1 = $request['altname1'];
        $alt_name2 = $request['altname2'];
        $alt_name3 = $request['altname3'];

        // Image field
        $request->file('image');

        // Bio, gender, Twitter and Instagram
        $this->bio = $request['bio'];
        $this->twitter = $request['twitter'];
        $this->instagram = $request['instagram'];
        $this->gender = $request['gender'];

        // save wrestler
        $this->save();
        $this->alt_names()->save(new AltName(['name' => $this->name]));

        // Handle alt name field 1
        if(!empty($alt_name1)) {
            if ($this->name != $alt_name1) {
                if ($alt_name_record = AltName::where('name', $alt_name1)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name1]));
                }
            }
        }

        // Handle alt name field 2
        if(!empty($alt_name2)) {
            if ($this->name != $alt_name2) {
                if ($alt_name_record = AltName::where('name', $alt_name2)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name2]));
                }
            }
        }

        // Handle alt name field 3
        if(!empty($alt_name3)) {
            if ($this->name != $alt_name3) {
                if ($alt_name_record = AltName::where('name', $alt_name3)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name3]));
                }
            }
        }

        // determine if image has been uploaded
        if(!empty($request->file('image'))){
            $uploaded_image = 1;
        } else {
            $uploaded_image = 0;
        }

        // handle image uploading if image has been uploaded
        if($uploaded_image == 1){
            $imagefile = $request->file('image');
            $image_name = $imagefile->getClientOriginalName();
            $imagefile->move('img', $image_name);
            $wrestler_image = new Image(['path' => $image_name]);
            $this->images()->save($wrestler_image);
        }
    }

    public function update_wrestler($request){

        $this->name = $request['name'];

        // Bio, Twitter and Instagram
        $this->bio = $request['bio'];
        $this->twitter = $request['twitter'];
        $this->instagram = $request['instagram'];
        $this->gender = $request['gender'];

        $this->update();

        //update first alt-name index which is simply the name of the wrestler
        $this->alt_names[0]->name = $request['name'];
        $this->alt_names[0]->update();

        // Alt name fields
        $alt_name1 = $request['altname1'];
        $alt_name2 = $request['altname2'];
        $alt_name3 = $request['altname3'];

        //Handle updating alt name field 1
        if(!empty($request['altname1'])){ //is field populated?
            if(!empty($this->alt_names[1])){ // does alt name 1 exist for wrestler?
                $this->alt_names[1]->name = $alt_name1; // if so, save over it
                $this->alt_names[1]->save();
            } else { // if altname1 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name1)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name1]));
                }

            }
        } elseif(!empty($this->alt_names[1])){ // if field is not populated, but altname1 exists for the user
            $temp_alt_name_1 = $this->alt_names[1];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $this->alt_names()->detach($this->alt_names[1]); // detach altname from wrestler
            if(count($temp_alt_name_1->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_1->delete(); //...delete it
            }
        }

        //Handle updating alt name field 2
        if(!empty($request['altname2'])){ //is field populated?
            if(!empty($this->alt_names[2])){ // does alt name 2 exist for wrestler?
                $this->alt_names[2]->name = $alt_name2; // if so, save over it
                $this->alt_names[2]->save();
            } else { // if altname2 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name2)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name2]));
                }

            }
        } elseif(!empty($this->alt_names[2])){ // if field is not populated, but altname2 exists for the user
            $temp_alt_name_2 = $this->alt_names[2];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $this->alt_names()->detach($this->alt_names[2]); // detach altname from wrestler
            if(count($temp_alt_name_2->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_2->delete(); //...delete it
            }
        }

        //Handle updating alt name field 3
        if(!empty($request['altname3'])){ //is field populated?
            if(!empty($this->alt_names[3])){ // does alt name 3 exist for wrestler?
                $this->alt_names[3]->name = $alt_name3; // if so, save over it
                $this->alt_names[3]->save();
            } else { // if altname3 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name3)->first()) {
                    $this->alt_names()->save($alt_name_record);
                } else {
                    $this->alt_names()->save(new AltName(['name' => $alt_name3]));
                }

            }
        } elseif(!empty($this->alt_names[3])){ // if field is not populated, but altname3 exists for the user
            $temp_alt_name_3 = $this->alt_names[3];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $this->alt_names()->detach($this->alt_names[3]); // detach altname from wrestler
            if(count($temp_alt_name_3->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_3->delete(); //...delete it
            }
        }

        // determine if image has been uploaded
        if(!empty($request->file('image'))){
            $uploaded_image = 1;
        } else {
            $uploaded_image = 0;
        }

        // handle image uploading if image has been uploaded
        if($uploaded_image == 1){
            $imagefile = $request->file('image');
            $image_name = $imagefile->getClientOriginalName();
            $imagefile->move('img', $image_name);
            $this->images[0]->path = $image_name;
            $this->images[0]->update();
        }
    }

    public function delete_wrestler(){

        // store alt names in temp array so we can access after detachment and deletion
        $temp_alt_names = $this->alt_names;

        // get rid of all ratings for wrestler
        $this->ratings()->delete();

        // detach alt names and remove wrestler
        $this->alt_names()->detach();
        $this->delete();

        // any alt names not being used by anyone else, delete them
        foreach($temp_alt_names as $alt_name){
            if(count($alt_name->wrestlers) < 1){
                $alt_name->delete();
            }
        }
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
