<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/30/2017
 * Time: 1:02 PM
 */

namespace App\Services\Repositories;


use App\Image;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository
{

    public function save($request){

        // create new post
        $post = new Post;

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
        $post->title = $request['title'];
        $post->subtitle = $request['subtitle'];
        $post->content = $request['content'];
        $post->user_id = Auth::user()->id;
        $post->save();

        // Attach image to post
        if($uploaded_image == 1) {
            $post->images()->save($post_image);
        }
    }

    public function update($id, $request){

        // get the post
        $post = $this->find($id);

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
        $post->title = $request['title'];
        $post->subtitle = $request['subtitle'];
        $post->content = $request['content'];
        $post->update();

        // Attach image to post, replacing the photo if it is already there
        if($uploaded_image == 1) {
            $post->images()->where('imageable_id', $post->id)->delete();
            $post->images()->save($post_image);
        }
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return Post::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Post::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return Post::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Post::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Post::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Post::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return Post::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return Post::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }
}