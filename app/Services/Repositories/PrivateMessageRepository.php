<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/1/2017
 * Time: 3:24 PM
 */

namespace App\Services\Repositories;


use App\Alert;
use App\PrivateMessage;
use Illuminate\Support\Facades\Auth;

class PrivateMessageRepository
{
    public function save($author, $recipient, $content, $pm = null){

        // if this is a new message, create a new PM
        if($pm == null){
            $pm = new PrivateMessage;
        }

        $pm->user_id = $recipient->id;
        $pm->author_id = $author->id;
        $pm->content = $content;
        $pm->save();
        $recipient->new_messages = 1;
        $recipient->save();

        // send alert if message is from admin
        //if($author->admin == 1){
        //    Alert::send_alert($recipient, "Admin Message", "info", $author->name . " has sent you a message.", route('pm_show', ['id' => $pm->id]));
       // }

        return $pm;
    }

    public function delete($pm){

        // get the logged-in user
        $user = Auth::user();

        // only delete from database if it has been trashed or there have been no replies and the original author is
        // doing the deleting
        if($pm->trash_id > 0 || (count($pm->replies) < 1) && $pm->author()->id == $user->id){
            // delete all replies as well as the message
            $pm->replies()->delete();
            $pm->delete();
        } else {
            // just simply trash the message but don't delete it from database
            $pm->trash_id = $user->id;
            $pm->save();
        }
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return PrivateMessage::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessage::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return PrivateMessage::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessage::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessage::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return PrivateMessage::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return PrivateMessage::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return PrivateMessage::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessage::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessage::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return PrivateMessage::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessage::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessage::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessage::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessage::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }
}