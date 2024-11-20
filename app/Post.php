<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    
    public function tag()
    {
        return $this->hasMany('App\Tag', 'id_post', 'id');
    }
    
}
