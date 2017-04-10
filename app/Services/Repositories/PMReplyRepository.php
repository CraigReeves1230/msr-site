<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/1/2017
 * Time: 4:40 PM
 */

namespace App\Services\Repositories;


use App\PrivateMessage;
use App\PrivateMessageReply;
use Illuminate\Support\Facades\Auth;

class PMReplyRepository
{

	protected $pm_repository;

	public function __construct(PrivateMessageRepository $pm_repository){
		$this->pm_repository = $pm_repository;
	}

	public function save($data){
        $id = $data['private_message_id'];
        $private_message = $this->pm_repository->find($id);
        $content = $data['content'];
        $author = Auth::user();
        $recipient_id = $private_message->author()->id;
        $reply = new PrivateMessageReply(['user_id' => $recipient_id,
            'author_id' => $author->id,
            'private_message_id' => $id,
            'content' => $content]);
        $reply->save();
        return redirect('user_dashboard/message/' . $id);
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return PrivateMessageReply::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessageReply::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return PrivateMessageReply::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessageReply::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessageReply::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return PrivateMessageReply::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return PrivateMessageReply::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return PrivateMessageReply::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessageReply::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessageReply::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return PrivateMessageReply::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessageReply::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessageReply::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return PrivateMessageReply::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return PrivateMessageReply::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }
}