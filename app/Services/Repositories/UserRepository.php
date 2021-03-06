<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 3/30/2017
 * Time: 1:02 PM
 */

namespace App\Services\Repositories;


use App\Image;
use App\User;
use Carbon\Carbon;

class UserRepository
{

    public function save($data){

        $user = new User;

        $user->name = $data['name'];
        $user->email = strtolower($data['email']);
        $user->admin = $data['admin'];
        $user->reset_digest = '';
        $user->reset_digest_time = Carbon::now();

        if(empty($data['summary'])){
            $user->summary = '';
        }

        $user->password = bcrypt($data['password']);
        $user->save();
        $image = new Image(['path' => $data['image']]);
        $user->images()->save($image);

        return $user;
    }

    public function update($id, $data){

        $user = $this->find($id);

        $user->name = $data['name'];
        $user->email = strtolower($data['email']);
        $user->reset_digest = "";

        if(empty($data['summary'])) {
            $user->summary = "";
        } else {
            $user->summary = $data['summary'];
        }

        if(empty($data['summary'])){
            $user->summary = "";
        }

        // update admin status if it has been changed
        if(!empty($data['admin'])){
            $user->admin = $data['admin'];
        }

        //update password if it has been changed
        if(!empty($data['password'])){
            $user->password = bcrypt($data['password']);
        }

        $user->update();

        //update image if it has been changed
        if(!empty($data['image'])){
            if(!empty($user->images[0])) {
                $user->images[0]->path = $data['image'];
                $user->images[0]->save();
            } else {
                $gen_image = new Image(['path' => $data['image']]);
                $user->images()->save($gen_image);
            }
        }
    }

    public function all($method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get') {
            return User::orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return User::orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function find($id){
        return User::findOrFail($id);
    }

    public function where($column, $operand, $value, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return User::where($column, $operand, $value)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return User::where($column, $operand, $value)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return User::where($column, $operand, $value)->first();
        }
    }

    public function whereIn($column, $array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc')
    {
        if ($method == 'get') {
            return User::whereIn($column, $array)->orderBy($order_index, $order)->get();
        } elseif ($method == 'paginate') {
            return User::whereIn($column, $array)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_multiple($array, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return User::where($array)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return User::where($array)->orderBy($order_index, $order)->paginate($per_page);
        } elseif($method == 'first'){
            return User::where($array)->first();
        }
    }

    public function where_optional_double($array1, $array2, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return User::where($array1)->orWhere($array2)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return User::where($array1)->orWhere($array2)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

    public function where_optional_triple($array1, $array2, $array3, $method = 'get', $per_page = 10, $order_index = 'id', $order = 'desc'){
        if($method == 'get'){
            return User::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->get();
        } elseif($method == 'paginate'){
            return User::where($array1)->orWhere($array2)->orWhere($array3)->orderBy($order_index, $order)->paginate($per_page);
        }
    }

}