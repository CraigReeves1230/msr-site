<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/2/2017
 * Time: 2:54 AM
 */

namespace App\Services;


use App\Image;

class ImageUploader
{
    public function get_image($request){

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
            $post_image = new Image(['path' => $image_name]);
        } else {
            $post_image = null;
        }

        return $post_image;
    }
}