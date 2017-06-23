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
use App\Services\ImageUploader;
use Illuminate\Support\Facades\Auth;

class PostRepository
{

    protected $image_uploader;

    public function __construct(ImageUploader $image_uploader){
        $this->image_uploader = $image_uploader;
    }

    public function save($request){

        // create new post
        $post = new Post;

        // handle image uploading if image has been uploaded
        $post_image = $this->image_uploader->get_image($request);

        // create post
        $post->title = $request['title'];
        $post->subtitle = $request['subtitle'];
        $post->content = $request['content'];
        $post->user_id = Auth::user()->id;
        $post->save();

        // Attach image to post
        if($post_image != null) {
            $post->images()->save($post_image);
        } else {
            $post_image->path = 'genericface.jpg';
            $post->images()->save($post_image);
        }

        // return the post in case it is needed
        return $post;
    }

    public function update($id, $request){

        // get the post
        $post = $this->find($id);

        // handle image uploading if image has been uploaded
        $post_image = $this->image_uploader->get_image($request);


        //handle locking/unlocking comments
        if($request['locked']){
            $post->locked = true;
        } elseif(!$request['locked']){
            $post->locked = false;
        }

        $post->title = $request['title'];
        $post->subtitle = $request['subtitle'];
        $post->content = $request['content'];
        $post->update();

        // Attach image to post, replacing the photo if it is already there
        if($post_image != null) {
            $post->images()->where('imageable_id', $post->id)->delete();
            $post->images()->save($post_image);
        }
    }

    public function delete($post){

        // remove all images associated with post
        $post->images()->delete();

    	// remove all replies from comments
		foreach($post->comments as $comment){
			$comment->replies()->delete();
		}

		// remove all comments from post
		$post->comments()->delete();

		// remove the post
    	$post->delete();
	}

	public function simple_save($post){
        $post->save();
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

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Post::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Post::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Post::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Post::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Post::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Post::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Post::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }
}