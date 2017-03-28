<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //mass assignment
    protected $fillable = ['title', 'subtitle', 'author', 'content', 'image'];

    //return images of Post
    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }

    //simple way to get a photo
    public function get_image(){
        return $this->images[0]->path;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function save_post($request){
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
        }

        // create post
        $this->title = $request['title'];
        $this->subtitle = $request['subtitle'];
        $this->content = $request['content'];
        $this->user_id = Auth::user()->id;
        $this->save();

        // Attach image to post
        if($uploaded_image == 1) {
            $this->images()->save($post_image);
        }
    }

    public function delete_post(){
        $this->delete();
    }

    public function update_post($request){

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
        }

        // update post
        $this->title = $request['title'];
        $this->subtitle = $request['subtitle'];
        $this->content = $request['content'];
        $this->update();

        // Attach image to post, replacing the photo if it is already there
        if($uploaded_image == 1) {
            $this->images()->where('imageable_id', $this->id)->delete();
            $this->images()->save($post_image);
        }
    }

    // returns the comments of a post
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }
}
