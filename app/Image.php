<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    //mass assignment permission
    protected $fillable = ['path'];

    //polymorphic relations
    public function imageable(){
        return $this->morphTo();
    }

    //provide image with file location with accessor
    public function getPathAttribute($value){
        $new_string = "/img/" . $value;
        return $new_string;
    }


}
