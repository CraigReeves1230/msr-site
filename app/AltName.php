<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AltName extends Model
{
    protected $fillable = ['name'];

    //returns wrestlers with alt name
    public function wrestlers(){
        return $this->belongsToMany('App\Wrestler');
    }
}
