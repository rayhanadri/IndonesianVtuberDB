<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vtuber extends Model
{
    //
    protected $casts = [
        'debut' => 'datetime',
    ];
    // protected $dates = ['debut'];
    public $timestamps = false;

}
