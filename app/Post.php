<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //mass assignment
    protected $fillable = ['title', 'subtitle', 'author', 'content', 'image', 'locked'];

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

    public function delete_post(){
        $this->delete();
    }

    // returns the comments of a post
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }
}
