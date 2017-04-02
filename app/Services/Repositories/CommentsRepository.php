<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/2/2017
 * Time: 6:41 PM
 */

namespace App\Services\Repositories;


use App\Comment;
use Illuminate\Support\Facades\Auth;

class CommentsRepository
{

    public function save($commentable, $data, $comment = null){

        if($comment == null){
            $comment = new Comment;
        }

        $comment->content = $data['content'];
        $comment->user_id = Auth::user()->id;
        $comment->likes = 0;
        $commentable->comments()->save($comment);
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return Comment::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Comment::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return Comment::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Comment::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Comment::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Comment::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return Comment::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return Comment::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Comment::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Comment::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return Comment::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Comment::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Comment::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return Comment::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return Comment::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

}