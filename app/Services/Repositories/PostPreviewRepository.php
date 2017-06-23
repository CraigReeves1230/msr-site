<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/11/2017
 * Time: 3:52 AM
 */

namespace App\Services\Repositories;


use App\PostPreview;
use App\Services\ImageUploader;
use Illuminate\Support\Facades\Auth;

class PostPreviewRepository
{
    protected $image_uploader;

    public function __construct(ImageUploader $image_uploader){
        $this->image_uploader = $image_uploader;
    }

    public function save($request){

        // create new post
        $preview = new PostPreview;

        // handle image uploading if image has been uploaded
        $preview_image = $this->image_uploader->get_image($request);

        // create post
        $preview->title = $request['title'];
        $preview->subtitle = $request['subtitle'];
        $preview->content = $request['content'];
        $preview->user_id = Auth::user()->id;
        $preview->save();

        // Attach image to post
        if($preview_image != null) {
            $preview->images()->save($preview_image);
        } else {
            $preview_image->path = 'genericface.jpg';
            $preview->images()->save($preview_image);
        }

        // return the post in case it is needed
        return $preview;
    }

    public function delete($preview){

        // delete all images
        $preview->images()->delete();

        // delete preview
        $preview->delete();
    }



}