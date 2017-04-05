<?php
/**
 * Created by PhpStorm.
 * User: reeve
 * Date: 4/5/2017
 * Time: 2:26 AM
 */

namespace App\Services;


class TokenMaker
{

    public function create(){
        $key = str_random(16);
        $key_encoded = bcrypt($key);
        $token_array = ['key' => $key, 'key_encoded' => $key_encoded];
        return $token_array;
    }

}