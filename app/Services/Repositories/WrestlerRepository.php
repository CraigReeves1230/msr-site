<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/30/2017
 * Time: 1:02 PM
 */

namespace App\Services\Repositories;


use App\AltName;
use App\Image;
use App\Services\ImageUploader;
use App\Wrestler;

class WrestlerRepository
{


    protected $image_uploader;

    public function __construct(ImageUploader $image_uploader)
    {

        $this->image_uploader = $image_uploader;
    }

    public function save($request){

        $wrestler = new Wrestler;

        $wrestler->name = $request['name'];

        // Alt name fields
        $alt_name1 = $request['altname1'];
        $alt_name2 = $request['altname2'];
        $alt_name3 = $request['altname3'];

        // Bio, gender, Twitter and Instagram
        $wrestler->bio = $request['bio'];
        $wrestler->twitter = $request['twitter'];
        $wrestler->instagram = $request['instagram'];
        $wrestler->gender = $request['gender'];

        // save wrestler
        $wrestler->save();
        $wrestler->alt_names()->save(new AltName(['name' => $wrestler->name]));

        // Handle alt name field 1
        if(!empty($alt_name1)) {
            if ($wrestler->name != $alt_name1) {
                if ($alt_name_record = AltName::where('name', $alt_name1)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name1]));
                }
            }
        }

        // Handle alt name field 2
        if(!empty($alt_name2)) {
            if ($wrestler->name != $alt_name2) {
                if ($alt_name_record = AltName::where('name', $alt_name2)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name2]));
                }
            }
        }

        // Handle alt name field 3
        if(!empty($alt_name3)) {
            if ($wrestler->name != $alt_name3) {
                if ($alt_name_record = AltName::where('name', $alt_name3)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name3]));
                }
            }
        }

        // get image and save
        $wrestler_image = $this->image_uploader->get_image($request);
        $wrestler->images()->save($wrestler_image);
    }

    public function update($id, $request){

        // get the wrestler
        $wrestler = $this->find($id);

        $wrestler->name = $request['name'];

        // Bio, Twitter and Instagram
        $wrestler->bio = $request['bio'];
        $wrestler->twitter = $request['twitter'];
        $wrestler->instagram = $request['instagram'];
        $wrestler->gender = $request['gender'];

        // determine if conversation is locked
        if($request['locked']){
            $wrestler->conversation_locked = true;
        } else{
            $wrestler->conversation_locked = false;
        }

        $wrestler->update();

        //update first alt-name index which is simply the name of the wrestler
        $wrestler->alt_names[0]->name = $request['name'];
        $wrestler->alt_names[0]->update();

        // Alt name fields
        $alt_name1 = $request['altname1'];
        $alt_name2 = $request['altname2'];
        $alt_name3 = $request['altname3'];

        //Handle updating alt name field 1
        if(!empty($request['altname1'])){ //is field populated?
            if(!empty($this->alt_names[1])){ // does alt name 1 exist for wrestler?
                $wrestler->alt_names[1]->name = $alt_name1; // if so, save over it
                $wrestler->alt_names[1]->save();
            } else { // if altname1 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name1)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name1]));
                }

            }
        } elseif(!empty($wrestler->alt_names[1])){ // if field is not populated, but altname1 exists for the user
            $temp_alt_name_1 = $wrestler->alt_names[1];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $wrestler->alt_names()->detach($wrestler->alt_names[1]); // detach altname from wrestler
            if(count($temp_alt_name_1->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_1->delete(); //...delete it
            }
        }

        //Handle updating alt name field 2
        if(!empty($request['altname2'])){ //is field populated?
            if(!empty($wrestler->alt_names[2])){ // does alt name 2 exist for wrestler?
                $wrestler->alt_names[2]->name = $alt_name2; // if so, save over it
                $wrestler->alt_names[2]->save();
            } else { // if altname2 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name2)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name2]));
                }

            }
        } elseif(!empty($wrestler->alt_names[2])){ // if field is not populated, but altname2 exists for the user
            $temp_alt_name_2 = $wrestler->alt_names[2];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $wrestler->alt_names()->detach($wrestler->alt_names[2]); // detach altname from wrestler
            if(count($temp_alt_name_2->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_2->delete(); //...delete it
            }
        }

        //Handle updating alt name field 3
        if(!empty($request['altname3'])){ //is field populated?
            if(!empty($wrestler->alt_names[3])){ // does alt name 3 exist for wrestler?
                $wrestler->alt_names[3]->name = $alt_name3; // if so, save over it
                $wrestler->alt_names[3]->save();
            } else { // if altname3 doesn't exist for wrestler

                // This is the same as in the create a new altname in the store function
                if ($alt_name_record = AltName::where('name', $alt_name3)->first()) {
                    $wrestler->alt_names()->save($alt_name_record);
                } else {
                    $wrestler->alt_names()->save(new AltName(['name' => $alt_name3]));
                }

            }
        } elseif(!empty($this->alt_names[3])){ // if field is not populated, but altname3 exists for the user
            $temp_alt_name_3 = $wrestler->alt_names[3];    // store in a temp variable the altname so that we can delete it later if it isn't being used by others
            $wrestler->alt_names()->detach($wrestler->alt_names[3]); // detach altname from wrestler
            if(count($temp_alt_name_3->wrestlers) < 1) { // after deleting, check to see if that altname is being used by anyone else, if not...
                $temp_alt_name_3->delete(); //...delete it
            }
        }

        // get image and save
        $wrestler_image = $this->image_uploader->get_image($request);
        if($wrestler_image != null) {
            $wrestler->images()->save($wrestler_image);
        }
    }

    public function delete($id){

        // get the wrestler
        $wrestler = $this->find($id);

        // store alt names in temp array so we can access after detachment and deletion
        $temp_alt_names = $wrestler->alt_names;

        // get rid of all ratings for wrestler
        $wrestler->ratings()->delete();

        // detach alt names and remove wrestler
        $wrestler->alt_names()->detach();
        $wrestler->delete();

        // any alt names not being used by anyone else, delete them
        foreach($temp_alt_names as $alt_name){
            if(count($alt_name->wrestlers) < 1){
                $alt_name->delete();
            }
        }
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return Wrestler::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Wrestler::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return Wrestler::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Wrestler::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Wrestler::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Wrestler::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return Wrestler::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return Wrestler::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Wrestler::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Wrestler::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Wrestler::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Wrestler::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Wrestler::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Wrestler::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Wrestler::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

}