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

class UserRepository
{

    public function save($data){

        $user = new User;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->admin = $data['admin'];

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
        $user->email = $data['email'];
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
            $user->images[0]->path = $data['image'];
            $user->images[0]->save();
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

}